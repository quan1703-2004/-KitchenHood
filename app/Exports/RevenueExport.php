<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RevenueExport
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Xuất báo cáo doanh thu
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Thiết lập tiêu đề báo cáo
        $sheet->setCellValue('A1', 'BÁO CÁO DOANH THU');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Thời gian báo cáo
        $sheet->setCellValue('A2', 'Từ ngày: ' . Carbon::parse($this->startDate)->format('d/m/Y') . ' - Đến ngày: ' . Carbon::parse($this->endDate)->format('d/m/Y'));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Lấy dữ liệu
        $startDateTime = Carbon::parse($this->startDate)->startOfDay();
        $endDateTime = Carbon::parse($this->endDate)->endOfDay();

        // Doanh thu theo ngày
        $dailyRevenue = Order::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Tổng doanh thu
        $totalRevenue = Order::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'delivered')
            ->sum('total_amount');

        $totalOrders = Order::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'delivered')
            ->count();

        // Header thông tin tổng quan
        $row = 4;
        $sheet->setCellValue('A' . $row, 'THỐNG KÊ TỔNG QUAN');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $this->applyHeaderStyle($sheet, 'A' . $row . ':B' . $row);

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng doanh thu:');
        $sheet->setCellValue('B' . $row, number_format($totalRevenue) . '₫');
        $sheet->getStyle('B' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng đơn hàng:');
        $sheet->setCellValue('B' . $row, number_format($totalOrders));

        $row++;
        $sheet->setCellValue('A' . $row, 'Giá trị đơn hàng TB:');
        $sheet->setCellValue('B' . $row, number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0) . '₫');

        // Bảng doanh thu theo ngày
        $row += 2;
        $sheet->setCellValue('A' . $row, 'CHI TIẾT DOANH THU THEO NGÀY');
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $this->applyHeaderStyle($sheet, 'A' . $row . ':F' . $row);

        // Header bảng
        $row++;
        $headers = ['STT', 'Ngày', 'Thứ', 'Doanh thu', 'Số đơn hàng', 'TB/Đơn'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $this->applyHeaderStyle($sheet, $col . $row);
            $col++;
        }

        // Dữ liệu
        $index = 1;
        foreach ($dailyRevenue as $day) {
            $row++;
            $date = Carbon::parse($day->date);
            $avgOrder = $day->orders > 0 ? $day->revenue / $day->orders : 0;

            $sheet->setCellValue('A' . $row, $index++);
            $sheet->setCellValue('B' . $row, $date->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $this->getDayOfWeek($date->dayOfWeek));
            $sheet->setCellValue('D' . $row, number_format($day->revenue) . '₫');
            $sheet->setCellValue('E' . $row, number_format($day->orders));
            $sheet->setCellValue('F' . $row, number_format($avgOrder) . '₫');

            // Căn giữa cột STT và số đơn hàng
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Căn phải cột tiền
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Border cho từng dòng
            $this->applyBorder($sheet, 'A' . $row . ':F' . $row);
        }

        // Doanh thu theo phương thức thanh toán
        $revenueByPayment = Order::whereBetween('created_at', [$startDateTime, $endDateTime])
            ->where('status', 'delivered')
            ->selectRaw('payment_method, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('payment_method')
            ->orderBy('revenue', 'desc')
            ->get();

        if ($revenueByPayment->count() > 0) {
            $row += 2;
            $sheet->setCellValue('A' . $row, 'DOANH THU THEO PHƯƠNG THỨC THANH TOÁN');
            $sheet->mergeCells('A' . $row . ':D' . $row);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $this->applyHeaderStyle($sheet, 'A' . $row . ':D' . $row);

            // Header
            $row++;
            $headers = ['STT', 'Phương thức', 'Doanh thu', 'Tỷ lệ'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $row, $header);
                $sheet->getStyle($col . $row)->getFont()->setBold(true);
                $this->applyHeaderStyle($sheet, $col . $row);
                $col++;
            }

            // Dữ liệu
            $index = 1;
            foreach ($revenueByPayment as $payment) {
                $row++;
                $percentage = $totalRevenue > 0 ? round(($payment->revenue / $totalRevenue) * 100, 1) : 0;

                $sheet->setCellValue('A' . $row, $index++);
                $sheet->setCellValue('B' . $row, $this->getPaymentMethodName($payment->payment_method));
                $sheet->setCellValue('C' . $row, number_format($payment->revenue) . '₫');
                $sheet->setCellValue('D' . $row, $percentage . '%');

                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $this->applyBorder($sheet, 'A' . $row . ':D' . $row);
            }
        }

        // Tự động điều chỉnh độ rộng cột
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Tạo file và trả về
        $writer = new Xlsx($spreadsheet);
        $fileName = 'bao-cao-doanh-thu-' . date('d-m-Y') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        return [
            'file' => $tempFile,
            'name' => $fileName
        ];
    }

    /**
     * Lấy tên thứ trong tuần
     */
    private function getDayOfWeek($day)
    {
        $days = [
            0 => 'Chủ nhật',
            1 => 'Thứ hai',
            2 => 'Thứ ba',
            3 => 'Thứ tư',
            4 => 'Thứ năm',
            5 => 'Thứ sáu',
            6 => 'Thứ bảy'
        ];
        return $days[$day] ?? '';
    }

    /**
     * Lấy tên phương thức thanh toán
     */
    private function getPaymentMethodName($method)
    {
        $methods = [
            'cod' => 'Thanh toán khi nhận hàng',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'vnpay' => 'VNPay',
            'qr_code' => 'QR Code',
            'credit_card' => 'Thẻ tín dụng'
        ];
        return $methods[$method] ?? ucfirst($method);
    }

    /**
     * Áp dụng style cho header
     */
    private function applyHeaderStyle($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8F5E9']
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '1B5E20']
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

