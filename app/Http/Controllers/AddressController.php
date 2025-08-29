<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Hiển thị danh sách địa chỉ của user
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    /**
     * Hiển thị form tạo địa chỉ mới
     */
    public function create()
    {
        return view('customer.addresses.create');
    }

    /**
     * Lưu địa chỉ mới
     */
    public function store(Request $request)
    {
        // Chuẩn hóa giá trị id từ select về số nguyên để tránh lỗi integer khi trình duyệt gửi chuỗi
        $request->merge([
            'province_id' => is_numeric($request->input('province_id')) ? (int) $request->input('province_id') : null,
            'district_id' => is_numeric($request->input('district_id')) ? (int) $request->input('district_id') : null,
            'ward_id'     => is_numeric($request->input('ward_id')) ? (int) $request->input('ward_id') : null,
        ]);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province_id' => 'required|integer',
            'province_name' => 'required|string|max:255',
            'district_id' => 'required|integer',
            'district_name' => 'required|string|max:255',
            'ward_id' => 'required|integer',
            'ward_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:10',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Nếu đây là địa chỉ đầu tiên hoặc user chọn làm mặc định
        if ($request->is_default || Auth::user()->addresses()->count() === 0) {
            // Bỏ mặc định tất cả địa chỉ khác
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address = new Address($request->all());
        $address->user_id = Auth::id();
        $address->is_default = $request->is_default || Auth::user()->addresses()->count() === 0;
        $address->save();

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được thêm thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa địa chỉ
     */
    public function edit(Address $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.addresses.edit', compact('address'));
    }

    /**
     * Cập nhật địa chỉ
     */
    public function update(Request $request, Address $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Chuẩn hóa giá trị id từ select về số nguyên để tránh lỗi integer khi trình duyệt gửi chuỗi
        $request->merge([
            'province_id' => is_numeric($request->input('province_id')) ? (int) $request->input('province_id') : null,
            'district_id' => is_numeric($request->input('district_id')) ? (int) $request->input('district_id') : null,
            'ward_id'     => is_numeric($request->input('ward_id')) ? (int) $request->input('ward_id') : null,
        ]);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province_id' => 'required|integer',
            'province_name' => 'required|string|max:255',
            'district_id' => 'required|integer',
            'district_name' => 'required|string|max:255',
            'ward_id' => 'required|integer',
            'ward_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:10',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Nếu chọn làm địa chỉ mặc định
        if ($request->is_default) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($request->all());
        $address->is_default = $request->is_default;
        $address->save();

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được cập nhật thành công!');
    }

    /**
     * Xóa địa chỉ
     */
    public function destroy(Address $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Không cho phép xóa địa chỉ mặc định nếu chỉ còn 1 địa chỉ
        if ($address->is_default && Auth::user()->addresses()->count() === 1) {
            return redirect()->route('addresses.index')->with('error', 'Không thể xóa địa chỉ mặc định cuối cùng!');
        }

        $address->delete();

        // Nếu xóa địa chỉ mặc định, đặt địa chỉ đầu tiên làm mặc định
        if ($address->is_default) {
            $firstAddress = Auth::user()->addresses()->first();
            if ($firstAddress) {
                $firstAddress->update(['is_default' => true]);
            }
        }

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được xóa thành công!');
    }

    /**
     * Đặt địa chỉ làm mặc định
     */
    public function setDefault(Address $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Bỏ mặc định tất cả địa chỉ khác
        Auth::user()->addresses()->update(['is_default' => false]);
        
        // Đặt địa chỉ này làm mặc định
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')->with('success', 'Đã đặt địa chỉ làm mặc định!');
    }

    /**
     * API để lấy danh sách địa chỉ (cho checkout)
     */
    public function getAddresses()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        return response()->json($addresses);
    }

    /**
     * API để lấy danh sách tỉnh thành
     */
    public function getProvinces()
    {
        try {
            $response = file_get_contents('https://esgoo.net/api-tinhthanh/1/0.htm');
            $data = json_decode($response, true);
            
            if ($data && $data['error'] == 0) {
                return response()->json($data['data']);
            }
            
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * API để lấy danh sách quận huyện theo tỉnh
     */
    public function getDistricts($provinceId)
    {
        try {
            $response = file_get_contents("https://esgoo.net/api-tinhthanh/2/{$provinceId}.htm");
            $data = json_decode($response, true);
            
            if ($data && $data['error'] == 0) {
                return response()->json($data['data']);
            }
            
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * API để lấy danh sách phường xã theo quận huyện
     */
    public function getWards($districtId)
    {
        try {
            $response = file_get_contents("https://esgoo.net/api-tinhthanh/3/{$districtId}.htm");
            $data = json_decode($response, true);
            
            if ($data && $data['error'] == 0) {
                return response()->json($data['data']);
            }
            
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }
}
