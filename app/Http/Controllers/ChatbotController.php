<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Nhận tin nhắn từ client và gọi Google AI Studio (Gemini API) để trả lời
     */
    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $apiKey = config('services.google_ai.api_key');
        $model = config('services.google_ai.model', 'gemini-1.5-flash');
        $verifySsl = (bool) config('services.google_ai.verify_ssl', true);
        $caBundle = config('services.google_ai.ca_bundle');

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'error' => 'Thiếu GOOGLE_API_KEY trong cấu hình.'
            ], 500);
        }

        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $payload = [
            // Theo API Google Generative Language v1beta
            'contents' => [[
                'parts' => [[
                    'text' => (string) $request->input('message')
                ]]
            ]],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 512,
            ],
        ];

        try {
            // Cấu hình Guzzle cho SSL linh hoạt trên môi trường DEV/Windows
            $guzzleOptions = [
                'timeout' => 20,
                'connect_timeout' => 10,
            ];
            if ($verifySsl === false) {
                // DEV: bỏ qua verify để tránh cURL error 60 (KHÔNG dùng production)
                $guzzleOptions['verify'] = false;
            } elseif (!empty($caBundle)) {
                // Chỉ định file CA nếu được cấu hình
                $guzzleOptions['verify'] = $caBundle;
            }

            $client = new \GuzzleHttp\Client($guzzleOptions);

            $response = $client->post($endpoint, [
                'query' => [
                    'key' => $apiKey,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($payload)
            ]);

            $data = json_decode((string) $response->getBody(), true);

            // Trích xuất text trả lời theo cấu trúc phản hồi của Google
            $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$answer) {
                Log::warning('Chatbot: không có câu trả lời từ Google', ['response' => $data]);
                return response()->json([
                    'success' => false,
                    'error' => 'Không nhận được phản hồi từ AI. Vui lòng thử lại.'
                ], 502);
            }

            return response()->json([
                'success' => true,
                'answer' => $answer,
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot call error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Lỗi gọi AI: ' . $e->getMessage(),
            ], 500);
        }
    }
}


