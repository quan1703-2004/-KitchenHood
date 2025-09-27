<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Hiển thị giao diện chat admin
     */
    public function index()
    {
        $admin = Auth::user();
        
        // Lấy danh sách khách hàng với thông tin tin nhắn chưa đọc
        $customers = User::where('role', 'customer')->get()->map(function($customer) use ($admin) {
            // Đếm tin nhắn chưa đọc từ customer
            $unreadCount = Message::where('sender_id', $customer->id)
                                  ->where('receiver_id', $admin->id)
                                  ->where('is_read', false)
                                  ->count();
            
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'avatar_url' => $customer->avatar ? $customer->avatar_url : null,
                'phone' => $customer->phone ?? 'Chưa cập nhật',
                'email_verified_at' => $customer->email_verified_at ? 'Đã xác thực' : 'Chưa xác thực',
                'created_at' => $customer->created_at->format('d/m/Y'),
                'unread_count' => $unreadCount,
                'orders_count' => 0, // Có thể thêm sau
                'total_spent' => 0, // Có thể thêm sau
                'last_login' => 'Chưa có thông tin' // Có thể thêm sau
            ];
        });
        
        return view('admin.chat.index', compact('customers'));
    }

    /**
     * Lấy dữ liệu chat cho component
     */
    public function getChatData()
    {
        $admin = Auth::user();
        
        // Lấy danh sách khách hàng với thông tin tin nhắn chưa đọc
        $customers = User::where('role', 'customer')->get()->map(function($customer) use ($admin) {
            // Đếm tin nhắn chưa đọc từ customer
            $unreadCount = Message::where('sender_id', $customer->id)
                                  ->where('receiver_id', $admin->id)
                                  ->where('is_read', false)
                                  ->count();
            
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'avatar_url' => $customer->avatar ? $customer->avatar_url : null,
                'phone' => $customer->phone ?? 'Chưa cập nhật',
                'email_verified_at' => $customer->email_verified_at ? 'Đã xác thực' : 'Chưa xác thực',
                'created_at' => $customer->created_at->format('d/m/Y'),
                'unread_count' => $unreadCount,
                'orders_count' => 0, // Có thể thêm sau
                'total_spent' => 0, // Có thể thêm sau
                'last_login' => 'Chưa có thông tin' // Có thể thêm sau
            ];
        });
        
        return response()->json([
            'success' => true,
            'customers' => $customers
        ]);
    }

    /**
     * Gửi tin nhắn từ admin tới customer
     */
    public function sendMessage(Request $request)
    {
        try {
            // Log request để debug
            Log::info('Admin sendMessage request', [
                'admin_id' => $request->user()?->id,
                'customer_id' => $request->input('customer_id'),
                'message_length' => strlen($request->input('message', '')),
                'has_csrf' => $request->hasHeader('X-CSRF-TOKEN')
            ]);

            // Validate input
            $request->validate([
                'customer_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000'
            ]);

            $admin = $request->user();
            $customer = User::findOrFail($request->input('customer_id'));
            $message = $request->input('message');

            // Lưu tin nhắn vào database
            $savedMessage = Message::create([
                'sender_id' => $admin->id,
                'sender_type' => 'admin',
                'receiver_id' => $customer->id,
                'receiver_type' => 'user',
                'message' => $message,
                'is_read' => false
            ]);

            // Broadcast tin nhắn tới customer
            try {
                event(new MessageSent($admin->name, $message, $admin->id, 'admin'));
            } catch (\Exception $e) {
                Log::warning('Admin broadcast failed: ' . $e->getMessage());
            }

            // Trả về response JSON cho AJAX
            return response()->json([
                'success' => true,
                'message' => 'Tin nhắn đã được gửi thành công!',
                'data' => [
                    'id' => $savedMessage->id,
                    'username' => $admin->name,
                    'message' => $message,
                    'timestamp' => $savedMessage->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i'),
                    'timestamp_full' => $savedMessage->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Admin validation error in sendMessage', [
                'errors' => $e->errors(),
                'admin_id' => $request->user()?->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Admin general error in sendMessage', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'admin_id' => $request->user()?->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy lịch sử chat giữa admin và customer cụ thể
     */
    public function getChatHistory(Request $request, $customerId)
    {
        $admin = $request->user();
        $customer = User::findOrFail($customerId);
        
        // Lấy tất cả tin nhắn giữa admin và customer
        $messages = Message::where(function($query) use ($admin, $customer) {
            $query->where(function($subQuery) use ($admin, $customer) {
                // Tin nhắn từ admin tới customer
                $subQuery->where('sender_id', $admin->id)
                         ->where('sender_type', 'admin')
                         ->where('receiver_id', $customer->id)
                         ->where('receiver_type', 'user');
            })->orWhere(function($subQuery) use ($admin, $customer) {
                // Tin nhắn từ customer tới admin
                $subQuery->where('sender_id', $customer->id)
                         ->where('sender_type', 'user')
                         ->where('receiver_id', $admin->id)
                         ->where('receiver_type', 'admin');
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
     * Đánh dấu tin nhắn đã đọc
     */
    public function markAsRead(Request $request, $customerId)
    {
        $admin = $request->user();
        
        // Đánh dấu tất cả tin nhắn từ customer này là đã đọc
        Message::where('sender_id', $customerId)
                ->where('receiver_id', $admin->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đánh dấu tin nhắn đã đọc'
        ]);
    }

    /**
     * Lấy thông tin chi tiết của customer
     */
    public function getCustomerInfo(Request $request, $customerId)
    {
        $customer = User::findOrFail($customerId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone ?? 'Chưa cập nhật',
                'created_at' => $customer->created_at->format('d/m/Y H:i'),
                'email_verified_at' => $customer->email_verified_at ? 'Đã xác thực' : 'Chưa xác thực',
                'last_login' => 'Chưa có thông tin', // Có thể thêm sau
                'orders_count' => 0, // Có thể thêm sau
                'total_spent' => 0 // Có thể thêm sau
            ]
        ]);
    }

    /**
     * Lấy số tin nhắn chưa đọc cho admin
     */
    public function getUnreadCount(Request $request)
    {
        $admin = $request->user();
        
        $count = Message::where('receiver_id', $admin->id)
                        ->where('is_read', false)
                        ->count();
        
        return response()->json(['count' => $count]);
    }
}