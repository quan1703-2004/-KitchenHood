<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm yêu thích
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem sản phẩm yêu thích!');
        }

        $favoriteProducts = Auth::user()->favoriteProducts()
            ->with(['category', 'reviews'])
            ->paginate(12);

        return view('customer.favorites.index', compact('favoriteProducts'));
    }

    /**
     * Thêm sản phẩm vào danh sách yêu thích
     */
    public function store(Request $request, $productId)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để thêm sản phẩm yêu thích!',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm yêu thích!');
        }

        $product = Product::findOrFail($productId);
        
        // Kiểm tra xem đã yêu thích chưa
        $existingFavorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingFavorite) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm đã có trong danh sách yêu thích!'
                ], 400);
            }
            return redirect()->back()->with('error', 'Sản phẩm đã có trong danh sách yêu thích!');
        }

        // Thêm vào danh sách yêu thích
        Favorite::create([
            'user_id' => Auth::id(),
            'product_id' => $productId
        ]);

        

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào danh sách yêu thích!',
                'favorites_count' => Auth::user()->favorites()->count()
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm ' . $product->name . ' vào danh sách yêu thích!');
    }

    /**
     * Xóa sản phẩm khỏi danh sách yêu thích
     */
    public function destroy(Request $request, $productId)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để xóa sản phẩm yêu thích!'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xóa sản phẩm yêu thích!');
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$favorite) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không có trong danh sách yêu thích!'
                ], 404);
            }
            return redirect()->back()->with('error', 'Sản phẩm không có trong danh sách yêu thích!');
        }

        $productName = $favorite->product->name;
        $favorite->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích!',
                'favorites_count' => Auth::user()->favorites()->count()
            ]);
        }

        return redirect()->back()->with('success', 'Đã xóa ' . $productName . ' khỏi danh sách yêu thích!');
    }

    /**
     * Toggle yêu thích sản phẩm (thêm/xóa)
     */
    public function toggle(Request $request, $productId)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để thêm sản phẩm yêu thích!',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm yêu thích!');
        }

        $product = Product::findOrFail($productId);
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            // Xóa khỏi yêu thích
            $favorite->delete();
            $isFavorited = false;
            $message = 'Đã xóa sản phẩm khỏi danh sách yêu thích!';
        } else {
            // Thêm vào yêu thích
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            $isFavorited = true;
            $message = 'Đã thêm sản phẩm vào danh sách yêu thích!';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_favorited' => $isFavorited,
                'favorites_count' => Auth::user()->favorites()->count()
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Kiểm tra trạng thái yêu thích của sản phẩm
     */
    public function check(Request $request, $productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'is_favorited' => false,
                'message' => 'Chưa đăng nhập'
            ]);
        }

        $isFavorited = Auth::user()->isFavorite($productId);

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'favorites_count' => Auth::user()->favorites()->count()
        ]);
    }
}