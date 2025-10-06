<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OrdersExport
{
    private string $startDate;
    private string $endDate;

    public function __construct(?string $startDate = null, ?string $endDate = null)
    {
        $this->startDate = $startDate ?: Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = $endDate ?: Carbon::now()->format('Y-m-d');
    }

    /**
     * Xuất báo cáo đơn hàng theo khoảng thời gian
     */
    public function export(): array
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tiêu đề
        $sheet->setCellValue('A1', 'BÁO CÁO ĐƠN HÀNG');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Thời gian: ' . Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y'));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $orders = Order::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        // Thống kê
        $row = 4;
        $sheet->setCellValue('A' . $row, 'THỐNG KÊ');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $this->styleHeader($sheet, 'A' . $row . ':B' . $row, 'E3F2FD', '0D47A1');

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng đơn hàng:');
        $sheet->setCellValue('B' . $row, number_format($orders->count()));

        $row++;
        $sheet->setCellValue('A' . $row, 'Tổng doanh thu:');
        $sheet->setCellValue('B' . $row, number_format($orders->sum('total_amount')) . '₫');

        // Bảng chi tiết
        $row += 2;
        $sheet->setCellValue('A' . $row, 'CHI TIẾT ĐƠN HÀNG');
        $sheet->mergeCells('A' . $row . ':H' . $row);
        $this->styleHeader($sheet, 'A' . $row . ':H' . $row, 'E8F5E9', '1B5E20');

        $row++;
        $headers = ['STT', 'Mã đơn', 'Khách hàng', 'Email', 'Ngày đặt', 'Trạng thái', 'Thanh toán', 'Tổng tiền'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $this->styleHeader($sheet, $col . $row, 'E8F5E9', '1B5E20');
            $col++;
        }

        $index = 1;
        foreach ($orders as $order) {
            $row++;
            $sheet->setCellValue('A' . $row, $index++);
            $sheet->setCellValue('B' . $row, $order->order_number);
            $sheet->setCellValue('C' . $row, $order->shipping_name ?? ($order->user->name ?? ''));
            $sheet->setCellValue('D' . $row, $order->user->email ?? '');
            $sheet->setCellValue('E' . $row, $order->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('F' . $row, $order->status);
            $sheet->setCellValue('G' . $row, $order->payment_status);
            $sheet->setCellValue('H' . $row, number_format($order->total_amount) . '₫');

            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'BDBDBD']
                    ]
                ]
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        foreach (range('A', 'H') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'bao-cao-don-hang-' . date('d-m-Y') . '.xlsx';
        $tmp = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tmp);
        return ['file' => $tmp, 'name' => $fileName];
    }

    private function styleHeader($sheet, $range, $bg, $fg): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $bg]
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => $fg]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
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


