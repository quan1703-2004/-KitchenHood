<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Address;

class PaymentController extends Controller
{
    // ==========================
    // Đặt cấu hình thông số MoMo test
    // ==========================
    private $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
    private $partnerCode = 'MOMOBKUN20180529';
    private $accessKey = 'klm05TvNBzhg7h7j';
    private $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    /**
     * Hiển thị trang thanh toán MoMo
     */
    public function momo($orderId)
    {
        $order = Order::where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        return view('customer.payment.momo', compact('order'));
    }

    /**
     * Tạo giao dịch MoMo và chuyển hướng người dùng
     */
    public function redirectToMoMo(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        $redirectUrl = route('payment.momo.callback');
        $ipnUrl = route('payment.momo.ipn');
        $orderId = time() . '_' . $order->id;
        $requestId = uniqid();

        $orderInfo = "Thanh toán đơn hàng #{$order->id}";
        $amount = (string) max(1000, (int) $order->total_amount); // test nên >= 1000
        $extraData = ''; // có thể base64_encode(json_encode(...))
        $requestType = 'payWithATM'; // có thể chuyển thành creditCard nếu lỗi
        
        $rawHash = "accessKey={$this->accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}"
            . "&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$this->partnerCode}"
            . "&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
        
        Log::info('MoMo rawHash for signature: ' . $rawHash);
        
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
        
        $payload = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => "KitchenHood Pro",
            'storeId' => "Store_01",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];

        Log::info('MoMo request payload: ', $payload);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
                ->withoutVerifying()
                ->post($this->endpoint, $payload);

            if (!$response->successful()) {
                Log::error('MoMo create payment failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()
                    ->route('orders.index')
                    ->with('error', 'Không thể kết nối MoMo (' . $response->status() . '). Vui lòng thử lại.');
            }

            $json = $response->json();
            Log::info('MoMo response:', $json);

            if (!empty($json['payUrl'])) {
                $order->update([
                    'momo_request_id' => $requestId,
                    'momo_order_id' => $orderId,
                ]);
                return redirect()->away($json['payUrl']);
            }

            // Không có payUrl → báo lỗi rõ
            $msg = $json['message'] ?? 'MoMo không trả về payUrl.';
            Log::error('MoMo payUrl missing', ['response' => $json]);
            return redirect()
                ->route('orders.index')
                ->with('error', 'Không tạo được link thanh toán MoMo: ' . $msg);

        } catch (\Exception $e) {
            Log::error('MoMo request exception', ['error' => $e->getMessage()]);
            return redirect()
                ->route('orders.index')
                ->with('error', 'Lỗi khi tạo thanh toán MoMo: ' . $e->getMessage());
        }
    }

    /**
     * Callback: người dùng được MoMo chuyển về sau thanh toán
     */
    public function callback(Request $request)
    {
        $resultCode = $request->input('resultCode'); // 0 = success
        
        // Có orderId thì lấy id thực từ "time_orderId"
        $order = null;
        if ($request->filled('orderId')) {
            $parts = explode('_', $request->orderId);
            $orderId = end($parts);
            $order = Order::find($orderId);
        }

        if ($resultCode === '0' || $resultCode === 0) {
            // ✅ Thành công: cập nhật trạng thái đơn và xóa giỏ hàng
            if ($order) {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid'
                ]);
                
                // Xóa giỏ hàng sau khi thanh toán thành công
                $cart = Cart::where('user_id', $order->user_id)->first();
                if ($cart) {
                    // Lấy danh sách sản phẩm trong đơn hàng để xóa khỏi giỏ hàng
                    $orderProductIds = $order->items->pluck('product_id')->toArray();
                    CartItem::where('cart_id', $cart->id)
                           ->whereIn('product_id', $orderProductIds)
                           ->delete();
                }
            }
            // Chuyển về trang thanh toán thành công
            return redirect()->route('payment.success', $order->id)
                ->with('success', 'Thanh toán MoMo thành công! Đơn hàng của bạn đã được cập nhật.');
        }

        // ❌ Thất bại/hủy: set trạng thái chờ thanh toán cho MoMo
        if ($order) {
            $order->update([
                'status' => 'waiting_payment', // Trạng thái đặc biệt cho MoMo chờ thanh toán
                'payment_status' => 'pending'
            ]);
        }
        
        // Chuyển về trang thanh toán thất bại
        return redirect()->route('payment.failed', $order->id)
            ->with('error', 'Thanh toán MoMo thất bại hoặc bị hủy. Vui lòng thử lại hoặc chọn phương thức thanh toán khác.');
    }

    /**
     * IPN: MoMo gọi ngầm (server-to-server) báo trạng thái
     */
    public function ipn(Request $request)
    {
        Log::info('MoMo IPN payload:', $request->all());
        
        // TODO: bạn nên xác thực chữ ký ở đây
        // Ví dụ cập nhật trạng thái dựa vào orderId/resultCode:
        if ($request->filled('orderId')) {
            $parts = explode('_', $request->orderId);
            $orderId = end($parts);
            if ($order = Order::find($orderId)) {
                if ((string)($request->resultCode) === '0') {
            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid'
            ]);
                } else {
        $order->update([
                        'status' => 'pending',
                        'payment_status' => 'failed'
                    ]);
                }
            }
        }
        
        return response()->json(['resultCode' => 0, 'message' => 'Received']);
    }

    /**
     * Cho phép user kéo lại đơn chưa thanh toán đi MoMo lần nữa
     */
    public function payAgain(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thanh toán lại đơn này.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.index')->with('info', 'Đơn này đã thanh toán.');
        }

        // Đưa về "chờ thanh toán" trước khi tạo giao dịch mới
        $order->update(['status' => 'waiting_payment']);
        
        // PHẢI return
        return $this->redirectToMoMo(new Request(), $order->id);
    }

    /**
     * Hiển thị trang thanh toán thành công
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('customer.payment.success', compact('order'));
    }

    /**
     * Hiển thị trang thanh toán thất bại
     */
    public function failed(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('customer.payment.failed', compact('order'));
    }

    /**
     * Chuyển đổi phương thức thanh toán sang COD
     */
    public function switchToCod(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thay đổi phương thức thanh toán đơn này.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.index')->with('error', 'Đơn này đã thanh toán.');
        }

        $order->update([
            'payment_method' => 'cod',
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        return redirect()->route('payment.success', $order->id)
            ->with('success', 'Đã chuyển sang thanh toán COD thành công!');
    }

    /**
     * Hủy đơn hàng và khôi phục giỏ hàng (method chung)
     */
    public function cancelOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền hủy đơn này.');
        }

        // Chỉ cho phép hủy đơn hàng chưa thanh toán
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.index')->with('error', 'Không thể hủy đơn hàng đã thanh toán.');
        }

        try {
            // Khôi phục tồn kho cho các sản phẩm
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->addStock(
                        $item->quantity,
                        "Hủy đơn hàng #{$order->order_number}",
                        Auth::id()
                    );
                }
            }

            // Khôi phục giỏ hàng
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            foreach ($order->items as $item) {
                $existingCartItem = CartItem::where('cart_id', $cart->id)
                                          ->where('product_id', $item->product_id)
                                          ->first();
                
                if ($existingCartItem) {
                    // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
                    $existingCartItem->update([
                        'quantity' => $existingCartItem->quantity + $item->quantity
                    ]);
                } else {
                    // Thêm mới vào giỏ hàng
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity
                    ]);
                }
            }

            // Xóa đơn hàng
            $order->delete();

            return redirect()->route('cart.index')
                           ->with('success', 'Đã hủy đơn hàng và khôi phục giỏ hàng thành công!');

        } catch (\Exception $e) {
            Log::error('Cancel order error: ' . $e->getMessage());
            return redirect()->route('orders.index')
                           ->with('error', 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại!');
        }
    }

}