<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Address;
use App\Models\MomoTransaction;
use App\Services\GhnService;
use App\Services\AddressMappingService;

class CheckoutController extends Controller
{
    /**
     * Tạo chữ ký HMAC SHA256 theo chuẩn MoMo
     */
    private function momoSign(string $rawHash, string $secretKey): string
    {
        // Ký dữ liệu theo thuật toán HMAC SHA256 của MoMo
        return hash_hmac('sha256', $rawHash, $secretKey);
    }

    /**
     * Gửi POST JSON tới endpoint MoMo
     */
    private function momoPostJson(string $endpoint, array $data): array
    {
        // Sử dụng cURL để gọi MoMo tương tự helper trong sample
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Trên Windows có thể thiếu CA bundle → tắt verify cho sandbox
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // Timeout tránh treo
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);
        $result = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        if ($curlError) {
            \Log::error('MoMo CURL error: ' . $curlError);
        }
        return json_decode((string) $result, true) ?: [];
    }

    /**
     * Fallback: gọi bằng Guzzle nếu cURL trả về rỗng
     */
    private function momoPostJsonWithGuzzle(string $endpoint, array $data): array
    {
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => false,
                'timeout' => 30,
                'connect_timeout' => 10,
            ]);
            $res = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]);
            $body = (string) $res->getBody();
            return json_decode($body, true) ?: [];
        } catch (\Throwable $e) {
            \Log::error('MoMo Guzzle error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Hiển thị trang thanh toán
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = CartItem::with('product.category')
            ->where('cart_id', $cart->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Lấy danh sách sản phẩm được chọn từ session
        $selectedItems = session('cart_selected_items', []);
        
        // Nếu không có sản phẩm nào được chọn, chuyển về giỏ hàng
        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        $cartItems = [];
        $total = 0;
        $shippingFee = 0;

        foreach ($items as $item) {
            // Chỉ xử lý các sản phẩm được chọn
            if (!in_array($item->product_id, $selectedItems)) {
                continue;
            }

            if ($item->product) {
                // Kiểm tra sản phẩm còn hàng không
                if ($item->product->quantity <= 0) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm "' . $item->product->name . '" đã hết hàng!');
                }

                // Kiểm tra số lượng có vượt quá tồn kho không
                if ($item->quantity > $item->product->quantity) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm "' . $item->product->name . '" chỉ còn ' . $item->product->quantity . ' sản phẩm!');
                }

                $lineTotal = $item->product->price * $item->quantity;
                $cartItems[] = [
                    'product' => $item->product,
                    'quantity' => $item->quantity,
                    'subtotal' => $lineTotal,
                ];
                $total += $lineTotal;
            }
        }

        // Nếu không có sản phẩm hợp lệ nào được chọn
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Không có sản phẩm hợp lệ để thanh toán!');
        }

        // Tính phí vận chuyển
        $shippingFee = 0;
        if ($total < 5000000) {
            $shippingFee = 50000; // 50,000 VNĐ
        }

        // Tính tổng cuối cùng
        $finalTotal = $total + $shippingFee;

        $addresses = Address::where('user_id', Auth::id())->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        return view('customer.checkout.index', compact('cartItems', 'total', 'shippingFee', 'finalTotal', 'addresses', 'defaultAddress'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,bank_transfer,momo',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Lấy danh sách sản phẩm được chọn từ session
        $selectedItems = session('cart_selected_items', []);
        
        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        $cartItems = [];
        $total = 0;

        foreach ($items as $item) {
            // Chỉ xử lý các sản phẩm được chọn
            if (!in_array($item->product_id, $selectedItems)) {
                continue;
            }

            if ($item->product) {
                // Kiểm tra sản phẩm còn hàng không
                if ($item->product->quantity <= 0) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm "' . $item->product->name . '" đã hết hàng!');
                }

                // Kiểm tra số lượng có vượt quá tồn kho không
                if ($item->quantity > $item->product->quantity) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm "' . $item->product->name . '" chỉ còn ' . $item->product->quantity . ' sản phẩm!');
                }

                $lineTotal = $item->product->price * $item->quantity;
                $cartItems[] = [
                    'product' => $item->product,
                    'quantity' => $item->quantity,
                    'subtotal' => $lineTotal,
                ];
                $total += $lineTotal;
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Không có sản phẩm hợp lệ để thanh toán!');
        }

        // Tính phí vận chuyển
        $shippingFee = 0;
        if ($total < 5000000) {
            $shippingFee = 50000; // 50,000 VNĐ
        }

        $finalAmount = $total + $shippingFee;

        // Kiểm tra quyền sở hữu địa chỉ
        $address = Address::where('id', $request->address_id)
                         ->where('user_id', Auth::id())
                         ->first();
        
        if (!$address) {
            return redirect()->back()->with('error', 'Địa chỉ không hợp lệ!');
        }

        try {
            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'order_code' => '', // Khởi tạo với giá trị rỗng, sẽ được cập nhật sau khi gọi GHN API
                'subtotal' => $total,
                'shipping_fee' => $shippingFee,
                'total_amount' => $finalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'shipping_address' => $address->full_address,
                'shipping_province_id' => $address->province_id,
                'shipping_province_name' => $address->province_name,
                'shipping_district_id' => $address->district_id,
                'shipping_district_name' => $address->district_name,
                'shipping_ward_id' => $address->ward_id,
                'shipping_ward_name' => $address->ward_name,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Tạo chi tiết đơn hàng và trừ tồn kho
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'product_price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Trừ tồn kho ngay khi tạo đơn hàng
                $item['product']->reduceStock(
                    $item['quantity'],
                    "Xuất hàng cho đơn hàng #{$order->order_number}",
                    $order->id,
                    Auth::id()
                );
            }

            // Xóa các sản phẩm đã đặt hàng khỏi giỏ hàng
            foreach ($cartItems as $item) {
                CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $item['product']->id)
                    ->delete();
            }

            // Xóa session lựa chọn sản phẩm
            session()->forget('cart_selected_items');

            // Tích hợp với GHN API để tạo đơn hàng vận chuyển
            $this->createGhnShippingOrder($order, $cartItems);

            // Xử lý thanh toán theo phương thức
            if ($request->payment_method === 'momo') {
                session(['momo_pending_order_id' => $order->id]);
                return redirect()->route('payment.momo.start', ['order' => $order->id]);
            } else {
                // COD hoặc bank transfer - đặt hàng thành công ngay
                return redirect()->route('checkout.success', $order->id)
                               ->with('success', 'Đặt hàng thành công!');
            }

        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!')
                           ->withInput();
        }
    }

    /**
     * Trang thành công sau khi đặt hàng
     */
    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('customer.checkout.success', compact('order'));
    }

    /**
     * Khởi tạo thanh toán MoMo (theo mẫu atm_momo.php)
     */
    public function momoStart(Request $request, Order $order)
    {
        // Kiểm tra quyền sở hữu đơn
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('checkout.index')->with('error', 'Không có quyền truy cập đơn hàng.');
        }

        // Lấy cấu hình từ file sample (momo_payment/php/basic.example/config.json)
        $configFile = base_path('momo_payment/php/basic.example/config.json');
        if (!file_exists($configFile)) {
            return redirect()->route('checkout.index')->with('error', 'Thiếu file cấu hình MoMo.');
        }
        $config = json_decode(file_get_contents($configFile), true);
        $partnerCode = $config['partnerCode'] ?? '';
        $accessKey = $config['accessKey'] ?? '';
        $secretKey = $config['secretKey'] ?? '';

        // Endpoint v2 theo hướng dẫn mới
        $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';

        // Dữ liệu đơn hàng
        $orderInfo = 'Thanh toán đơn hàng ' . $order->order_number;
        $amount = (string) ($order->total_amount);
        $orderId = (string) ($order->id . '-' . time());
        // Callback
        $returnUrl = route('payment.momo.return');
        // Sandbox có thể không chấp nhận notifyUrl là localhost → tạm thời dùng cùng returnUrl để test
        $notifyUrl = $returnUrl;
        $requestId = (string) time();
        $requestType = 'payWithATM';
        $extraData = '';

        // Tạo chuỗi ký theo mẫu v2 (thứ tự tham số phải chuẩn)
        $rawHash =
            'accessKey=' . $accessKey .
            '&amount=' . $amount .
            '&extraData=' . $extraData .
            '&ipnUrl=' . $notifyUrl .
            '&orderId=' . $orderId .
            '&orderInfo=' . $orderInfo .
            '&partnerCode=' . $partnerCode .
            '&redirectUrl=' . $returnUrl .
            '&requestId=' . $requestId .
            '&requestType=' . $requestType;

        $signature = $this->momoSign($rawHash, $secretKey);

        $payload = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'Test',
            'storeId' => 'MomoTestStore',
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];

        // Gọi theo cách tự xây cURL trước
        $response = $this->momoPostJson($endpoint, $payload);

        // Nếu không có phản hồi, thử gọi đúng helper của sample MoMo để đảm bảo tương thích
        if (empty($response)) {
            $helperPath = base_path('momo_payment/php/basic.example/common/helper.php');
            if (file_exists($helperPath)) {
                include_once $helperPath; // cung cấp hàm execPostRequest
                if (function_exists('execPostRequest')) {
                    $raw = execPostRequest($endpoint, json_encode($payload));
                    $decoded = json_decode((string) $raw, true);
                    if (is_array($decoded)) {
                        $response = $decoded;
                    }
                }
            }
        }

        // Nếu vẫn rỗng, thử thêm Guzzle fallback
        if (empty($response) && class_exists('GuzzleHttp\\Client')) {
            $response = $this->momoPostJsonWithGuzzle($endpoint, $payload);
        }

        \Log::info('MoMo init payload (mask)', [
            'partnerCode' => $partnerCode,
            'accessKey' => substr($accessKey, 0, 4) . '***',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'requestType' => $requestType,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyUrl,
        ]);

        if (!empty($response['payUrl'])) {
            return redirect()->away($response['payUrl']);
        }

        \Log::error('MoMo init error', ['response' => $response]);
        return redirect()->route('checkout.index')->with('error', 'Không thể khởi tạo thanh toán MoMo.');
    }

    /**
     * Xử lý returnUrl từ MoMo (user redirect về)
     */
    public function momoReturn(Request $request)
    {
        $orderIdSession = session('momo_pending_order_id');
        if (!$orderIdSession) {
            return redirect()->route('checkout.index')->with('error', 'Không tìm thấy đơn hàng chờ.');
        }
        $order = Order::find($orderIdSession);
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Theo MoMo v2: resultCode == 0 là thành công; một số luồng cũ trả errorCode == 0
        $resultCode = $request->input('resultCode');
        $errorCode = $request->input('errorCode');
        $isSuccess = ((string)$resultCode === '0') || ((string)$errorCode === '0');

        if ($isSuccess) {
            // Lưu log giao dịch MoMo vào DB để đối soát
            try {
                MomoTransaction::create([
                    'order_id' => $order->id,
                    'partner_code' => $request->input('partnerCode'),
                    'access_key' => $request->input('accessKey'),
                    'request_id' => $request->input('requestId'),
                    'momo_order_id' => $request->input('orderId'),
                    'trans_id' => $request->input('transId'),
                    'amount' => (int) $request->input('amount', $order->total_amount),
                    'pay_type' => $request->input('payType') ?: $request->input('paymentOption'),
                    'result_code' => (string) ($resultCode ?? $errorCode),
                    'message' => $request->input('message'),
                    'raw_return' => json_encode($request->all()),
                    'ip_address' => $request->ip(),
                ]);
            } catch (\Throwable $e) {
                \Log::warning('Save MoMo transaction failed: ' . $e->getMessage());
            }
            // Thanh toán thành công: cập nhật trạng thái, xóa giỏ
            $order->payment_status = 'paid';
            $order->status = 'processing';
            $order->save();

            // Xóa giỏ
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            CartItem::where('cart_id', $cart->id)->delete();

            session()->forget('momo_pending_order_id');
            return redirect()->route('checkout.success', $order->id)->with('success', 'Thanh toán MoMo thành công!');
        }

        // Thất bại
        $order->payment_status = 'failed';
        $order->save();
        session()->forget('momo_pending_order_id');
        return redirect()->route('checkout.index')->with('error', 'Thanh toán MoMo thất bại.');
    }

    /**
     * Xử lý notifyUrl (server to server). Có thể chỉ log/cập nhật nếu cần.
     */
    public function momoNotify(Request $request)
    {
        // Ở sandbox, có thể nhận một số field, tùy vào cấu hình MoMo
        \Log::info('MoMo notify', $request->all());
        return response()->json(['status' => 'ok']);
    }

    /**
     * Tạo đơn hàng vận chuyển trên GHN API
     * 
     * @param Order $order Đơn hàng đã tạo
     * @param array $cartItems Danh sách sản phẩm trong đơn hàng
     * @return void
     */
    private function createGhnShippingOrder(Order $order, array $cartItems): void
    {
        try {
            $ghnService = new GhnService();
            
            // Lấy ward_code từ ward_id thông qua GHN API
            $wardCode = $ghnService->getWardCodeFromWardId($order->shipping_district_id, $order->shipping_ward_id);
            
            // Nếu không tìm thấy ward code, sử dụng ward_id làm fallback
            if (!$wardCode) {
                \Log::warning('GHN Integration - Không tìm thấy ward code', [
                    'order_id' => $order->id,
                    'district_id' => $order->shipping_district_id,
                    'ward_id' => $order->shipping_ward_id,
                    'fallback_to_ward_id' => true
                ]);
                $wardCode = (string)$order->shipping_ward_id;
            }
            
            // Chuẩn bị dữ liệu cho GHN API
            $orderData = [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'shipping_name' => $order->shipping_name,
                'shipping_phone' => $order->shipping_phone,
                'shipping_address' => $order->shipping_address,
                'shipping_district_id' => $order->shipping_district_id,
                'shipping_ward_code' => $wardCode,
                'total_amount' => $order->total_amount,
                'notes' => $order->notes,
                'items' => $cartItems
            ];

            // Gọi GHN API để tạo đơn hàng vận chuyển
            $ghnResult = $ghnService->createShippingOrder($orderData);

            if ($ghnResult && isset($ghnResult['data']['order_code'])) {
                // Cập nhật mã đơn hàng GHN vào database
                $order->order_code = $ghnResult['data']['order_code'];
                $order->save();

                \Log::info('GHN Integration - Đơn hàng được tạo thành công', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'ghn_order_code' => $ghnResult['data']['order_code']
                ]);
            } else {
                \Log::warning('GHN Integration - Không thể tạo đơn hàng vận chuyển', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'ghn_response' => $ghnResult
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('GHN Integration - Lỗi khi tạo đơn hàng vận chuyển', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}