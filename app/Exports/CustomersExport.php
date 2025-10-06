<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CustomersExport
{
    protected $sortBy;

    public function __construct($sortBy = 'orders')
    {
        $this->sortBy = $sortBy;
    }

    /**
     * Xuất báo cáo khách hàng
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Thiết lập tiêu đề báo cáo
        $sheet->setCellValue('A1', 'BÁO CÁO KHÁCH HÀNG');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Thời gian tạo báo cáo
        $sheet->setCellValue('A2', 'Ngày tạo: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Lấy dữ liệu khách hàng
        $query = User::withCount('orders')
            ->withSum(['orders' => function($query) {
                $query->where('status', 'delivered');
            }], 'total_amount');

        // Sắp xếp
        switch ($this->sortBy) {
            case 'revenue':
                $query->orderBy('orders_sum_total_amount', 'desc');
                break;
            case 'registration':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('orders_count', 'desc');
        }

        $customers = $query->get();

        // Thống kê tổng quan
        $totalCustomers = User::count();
        $activeCustomers = User::whereHas('orders', function($q) {
            $q->where('status', 'delivered');
        })->count();
        $newCustomersThisMonth = User::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        $totalRevenue = DB::table('orders')
            ->where('status', 'delivered')
            ->sum('total_amount');
        $deliveredOrders = DB::table('orders')
            ->where('status', 'delivered')
            ->count();
        $avgOrderValue = $deliveredOrders > 0 ? $totalRevenue / $deliveredOrders : 0;

        // Header thông tin tổng quan
        $row = 4;
        $sheet->setCellValue('A' . $row, 'THỐNG KÊ TỔNG QUAN');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $this->applyHeaderStyle($sheet, 'A' . $row . ':B' . $row);

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng khách hàng:');
        $sheet->setCellValue('B' . $row, number_format($totalCustomers));

        $row++;
        $sheet->setCellValue('A' . $row, 'Khách hàng hoạt động:');
        $sheet->setCellValue('B' . $row, number_format($activeCustomers));

        $row++;
        $sheet->setCellValue('A' . $row, 'Khách hàng mới tháng này:');
        $sheet->setCellValue('B' . $row, number_format($newCustomersThisMonth));

        $row++;
        $sheet->setCellValue('A' . $row, 'Giá trị đơn hàng TB:');
        $sheet->setCellValue('B' . $row, number_format($avgOrderValue) . '₫');

        // Bảng danh sách khách hàng
        $row += 2;
        $sheet->setCellValue('A' . $row, 'DANH SÁCH KHÁCH HÀNG');
        $sheet->mergeCells('A' . $row . ':G' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $this->applyHeaderStyle($sheet, 'A' . $row . ':G' . $row);

        // Header bảng
        $row++;
        $headers = ['STT', 'ID', 'Tên khách hàng', 'Email', 'Số đơn hàng', 'Tổng chi tiêu', 'Ngày đăng ký'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $this->applyHeaderStyle($sheet, $col . $row);
            $col++;
        }

        // Dữ liệu
        $index = 1;
        foreach ($customers as $customer) {
            $row++;
            $sheet->setCellValue('A' . $row, $index++);
            $sheet->setCellValue('B' . $row, $customer->id);
            $sheet->setCellValue('C' . $row, $customer->name);
            $sheet->setCellValue('D' . $row, $customer->email);
            $sheet->setCellValue('E' . $row, number_format($customer->orders_count));
            $sheet->setCellValue('F' . $row, number_format($customer->orders_sum_total_amount ?? 0) . '₫');
            $sheet->setCellValue('G' . $row, $customer->created_at->format('d/m/Y'));

            // Căn giữa cột STT, ID, số đơn
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Căn phải cột tiền
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Border cho từng dòng
            $this->applyBorder($sheet, 'A' . $row . ':G' . $row);
        }

        // Tự động điều chỉnh độ rộng cột
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Tạo file và trả về
        $writer = new Xlsx($spreadsheet);
        $fileName = 'bao-cao-khach-hang-' . date('d-m-Y') . '.xlsx';
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
                'startColor' => ['rgb' => 'FFF9C4']
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'F57F17']
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

