<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Hiển thị giao diện chat cho customer
     */
    public function index()
    {
        return view('customer.chat.index');
    }

    public function sendMessage(Request $request)
    {
        try {
            // Log request để debug
            \Log::info('Chat sendMessage request', [
                'user_id' => $request->user()?->id,
                'message_length' => strlen($request->input('message', '')),
                'has_csrf' => $request->hasHeader('X-CSRF-TOKEN')
            ]);

            // Validate input
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            // Lấy thông tin người gửi
            $user = $request->user();
            $username = $user ? $user->name : 'Khách';
            $message = $request->input('message');

        // Lưu tin nhắn vào database (nếu có user đăng nhập)
        $savedMessages = [];
        if ($user) {
            try {
                // Lấy tất cả admin trong hệ thống
                $allAdmins = User::where('role', 'admin')->get();
                \Log::info('Found admins count: ' . $allAdmins->count());
                
                // Tạo tin nhắn cho từng admin
                foreach ($allAdmins as $admin) {
                    $savedMessage = Message::create([
                        'sender_id' => $user->id,
                        'sender_type' => 'user',
                        'receiver_id' => $admin->id, // Gửi tới admin cụ thể
                        'receiver_type' => 'admin',
                        'message' => $message,
                        'is_read' => false
                    ]);
                    $savedMessages[] = $savedMessage;
                }
                
                // Nếu không có admin nào, tạo tin nhắn broadcast
                if ($allAdmins->isEmpty()) {
                    $savedMessage = Message::create([
                        'sender_id' => $user->id,
                        'sender_type' => 'user',
                        'receiver_id' => 0, // Broadcast tới tất cả admin
                        'receiver_type' => 'admin',
                        'message' => $message,
                        'is_read' => false
                    ]);
                    $savedMessages[] = $savedMessage;
                }
            } catch (\Exception $e) {
                \Log::error('Lỗi lưu tin nhắn: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi lưu tin nhắn'
                ], 500);
            }
        }

        // Broadcast tin nhắn tới tất cả client đang lắng nghe kênh chat-channel
        try {
            event(new MessageSent($username, $message, $user ? $user->id : null, 'user'));
        } catch (\Exception $e) {
            \Log::warning('Broadcast failed: ' . $e->getMessage());
        }

            // Trả về response JSON cho AJAX
            return response()->json([
                'success' => true,
                'message' => 'Tin nhắn đã được gửi thành công!',
                'data' => [
                    'id' => !empty($savedMessages) ? $savedMessages[0]->id : null,
                    'username' => $username,
                    'message' => $message,
                    'receivers_count' => count($savedMessages),
                    'timestamp' => !empty($savedMessages) ? $savedMessages[0]->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i') : now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i'),
                    'timestamp_full' => !empty($savedMessages) ? $savedMessages[0]->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : now()->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in sendMessage', [
                'errors' => $e->errors(),
                'user_id' => $request->user()?->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('General error in sendMessage', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $request->user()?->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy lịch sử chat giữa customer và admin
     */
    public function getChatHistory(Request $request)
    {
        $user = $request->user();
        
        // Nếu không có user đăng nhập, trả về danh sách rỗng
        if (!$user) {
        return response()->json([
            'success' => true,
                'data' => []
            ]);
        }
        
        // Lấy tất cả tin nhắn giữa customer và admin
        $messages = Message::where(function($query) use ($user) {
            $query->where(function($subQuery) use ($user) {
                // Tin nhắn từ customer tới admin
                $subQuery->where('sender_id', $user->id)
                         ->where('sender_type', 'user')
                         ->where('receiver_type', 'admin');
            })->orWhere(function($subQuery) use ($user) {
                // Tin nhắn từ admin tới customer
                $subQuery->where('receiver_id', $user->id)
                         ->where('receiver_type', 'user')
                         ->where('sender_type', 'admin');
            });
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function($message) {
            return [
                'id' => $message->id,
                'sender_name' => $message->sender ? $message->sender->name : 'Admin',
                'sender_type' => $message->sender_type,
                'receiver_name' => $message->receiver ? $message->receiver->name : 'Khách',
                'receiver_type' => $message->receiver_type,
                'message' => $message->message,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i'),
                'created_at_full' => $message->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Lấy số tin nhắn chưa đọc
     */
    public function getUnreadCount(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['count' => 0]);
        }
        
        $count = Message::where('receiver_id', $user->id)
                        ->where('is_read', false)
                        ->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Lấy dữ liệu chat cho component customer
     */
    public function getChatData()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Người dùng chưa đăng nhập'
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}