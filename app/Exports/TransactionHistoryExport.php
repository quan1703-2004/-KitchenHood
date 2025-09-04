<?php

namespace App\Exports;

use App\Models\InventoryTransaction;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransactionHistoryExport
{
    public function export($filters = [])
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Thiết lập tiêu đề
        $sheet->setTitle('Lịch Sử Giao Dịch');
        
        // Thiết lập header
        $headers = [
            'A1' => 'Ngày',
            'B1' => 'Sản phẩm',
            'C1' => 'Loại giao dịch',
            'D1' => 'Số lượng',
            'E1' => 'Tồn kho trước',
            'F1' => 'Tồn kho sau',
            'G1' => 'Người thực hiện',
            'H1' => 'Đơn hàng',
            'I1' => 'Ghi chú'
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Style cho header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        
        // Lấy dữ liệu giao dịch với filter
        $query = InventoryTransaction::with(['product', 'user', 'order']);
        
        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }
        
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        
        $transactions = $query->latest()->get();
        
        $row = 2;
        foreach ($transactions as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('B' . $row, $transaction->product->name);
            
            // Loại giao dịch
            if ($transaction->type === 'in') {
                $type = 'Nhập hàng';
                $typeColor = '008000'; // Xanh
            } else {
                $type = 'Xuất hàng';
                $typeColor = 'FF0000'; // Đỏ
            }
            
            $sheet->setCellValue('C' . $row, $type);
            $sheet->setCellValue('D' . $row, $transaction->quantity);
            $sheet->setCellValue('E' . $row, $transaction->quantity_before);
            $sheet->setCellValue('F' . $row, $transaction->quantity_after);
            $sheet->setCellValue('G' . $row, $transaction->user_name);
            
            // Đơn hàng
            $orderInfo = $transaction->order ? '#' . $transaction->order->order_number : '-';
            $sheet->setCellValue('H' . $row, $orderInfo);
            
            $sheet->setCellValue('I' . $row, $transaction->notes ?? '-');
            
            // Style cho loại giao dịch
            $sheet->getStyle('C' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($typeColor));
            
            $row++;
        }
        
        // Style cho dữ liệu
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        
        $sheet->getStyle('A2:I' . ($row - 1))->applyFromArray($dataStyle);
        
        // Căn chỉnh cột
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(30);
        
        // Căn giữa cho các cột
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C:C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D:D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Wrap text cho cột ghi chú
        $sheet->getStyle('I:I')->getAlignment()->setWrapText(true);
        
        // Tạo file
        $writer = new Xlsx($spreadsheet);
        $filename = 'transaction_history_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = storage_path('app/public/exports/' . $filename);
        
        // Tạo thư mục nếu chưa có
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $writer->save($filepath);
        
        return $filepath;
    }
}
