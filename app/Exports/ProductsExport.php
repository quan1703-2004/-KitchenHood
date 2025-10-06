<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductsExport
{
    protected $categoryId;
    protected $sortBy;

    public function __construct($categoryId = null, $sortBy = 'sales')
    {
        $this->categoryId = $categoryId;
        $this->sortBy = $sortBy;
    }

    /**
     * Xuất báo cáo sản phẩm
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Thiết lập tiêu đề báo cáo
        $sheet->setCellValue('A1', 'BÁO CÁO SẢN PHẨM');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Thời gian tạo báo cáo
        $sheet->setCellValue('A2', 'Ngày tạo: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Lấy dữ liệu
        $query = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                     ->where('orders.status', '=', 'delivered');
            })
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'categories.name as category_name',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(order_items.subtotal), 0) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'categories.name');

        // Lọc theo danh mục nếu có
        if ($this->categoryId) {
            $query->where('products.category_id', $this->categoryId);
        }

        // Sắp xếp
        switch ($this->sortBy) {
            case 'revenue':
                $query->orderBy('total_revenue', 'desc');
                break;
            case 'orders':
                $query->orderBy('order_count', 'desc');
                break;
            default:
                $query->orderBy('total_sold', 'desc');
        }

        $products = $query->get();

        // Thống kê tổng quan
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $productsWithSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->distinct('order_items.product_id')
            ->count('order_items.product_id');
        $avgPrice = Product::avg('price');

        // Header thông tin tổng quan
        $row = 4;
        $sheet->setCellValue('A' . $row, 'THỐNG KÊ TỔNG QUAN');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $this->applyHeaderStyle($sheet, 'A' . $row . ':B' . $row);

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng sản phẩm:');
        $sheet->setCellValue('B' . $row, number_format($totalProducts));

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng danh mục:');
        $sheet->setCellValue('B' . $row, number_format($totalCategories));

        $row++;
        $sheet->setCellValue('A' . $row, 'Sản phẩm có bán:');
        $sheet->setCellValue('B' . $row, number_format($productsWithSales));

        $row++;
        $sheet->setCellValue('A' . $row, 'Giá trung bình:');
        $sheet->setCellValue('B' . $row, number_format($avgPrice) . '₫');

        // Bảng chi tiết sản phẩm
        $row += 2;
        $sheet->setCellValue('A' . $row, 'CHI TIẾT SẢN PHẨM');
        $sheet->mergeCells('A' . $row . ':H' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $this->applyHeaderStyle($sheet, 'A' . $row . ':H' . $row);

        // Header bảng
        $row++;
        $headers = ['STT', 'ID', 'Tên sản phẩm', 'Danh mục', 'Giá', 'Đã bán', 'Doanh thu', 'Số đơn'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $this->applyHeaderStyle($sheet, $col . $row);
            $col++;
        }

        // Dữ liệu
        $index = 1;
        foreach ($products as $product) {
            $row++;
            $sheet->setCellValue('A' . $row, $index++);
            $sheet->setCellValue('B' . $row, $product->id);
            $sheet->setCellValue('C' . $row, $product->name);
            $sheet->setCellValue('D' . $row, $product->category_name ?? 'Không có');
            $sheet->setCellValue('E' . $row, number_format($product->price) . '₫');
            $sheet->setCellValue('F' . $row, number_format($product->total_sold));
            $sheet->setCellValue('G' . $row, number_format($product->total_revenue) . '₫');
            $sheet->setCellValue('H' . $row, number_format($product->order_count));

            // Căn giữa cột STT, ID, và số đơn
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Căn phải cột tiền
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Border cho từng dòng
            $this->applyBorder($sheet, 'A' . $row . ':H' . $row);
        }

        // Tự động điều chỉnh độ rộng cột
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Tạo file và trả về
        $writer = new Xlsx($spreadsheet);
        $fileName = 'bao-cao-san-pham-' . date('d-m-Y') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return [
            'file' => $tempFile,
            'name' => $fileName
        ];
    }

    /**
     * Áp dụng style cho header
     */
    private function applyHeaderStyle($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E3F2FD']
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '0D47A1']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
        $this->applyBorder($sheet, $range);
    }

    /**
     * Áp dụng border
     */
    private function applyBorder($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'BDBDBD']
                ]
            ]
        ]);
    }
}

