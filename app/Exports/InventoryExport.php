<?php

namespace App\Exports;

use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class InventoryExport
{
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Thiết lập tiêu đề
        $sheet->setTitle('Báo Cáo Tồn Kho');
        
        // Thiết lập header
        $headers = [
            'A1' => 'ID Sản phẩm',
            'B1' => 'Tên sản phẩm',
            'C1' => 'Danh mục',
            'D1' => 'Số lượng tồn kho',
            'E1' => 'Trạng thái',
            'F1' => 'Giá (VNĐ)',
            'G1' => 'Ngày cập nhật'
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
                'startColor' => ['rgb' => '2563EB'],
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
        
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
        
        // Lấy dữ liệu sản phẩm
        $products = Product::with('category')->orderBy('quantity', 'asc')->get();
        
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product->id);
            $sheet->setCellValue('B' . $row, $product->name);
            $sheet->setCellValue('C' . $row, $product->category->name ?? 'N/A');
            $sheet->setCellValue('D' . $row, $product->quantity);
            
            // Trạng thái tồn kho
            if ($product->quantity <= 0) {
                $status = 'Hết hàng';
                $statusColor = 'FF0000'; // Đỏ
            } elseif ($product->quantity <= 10) {
                $status = 'Sắp hết hàng';
                $statusColor = 'FFA500'; // Cam
            } else {
                $status = 'Còn hàng';
                $statusColor = '008000'; // Xanh
            }
            
            $sheet->setCellValue('E' . $row, $status);
            $sheet->setCellValue('F' . $row, number_format($product->price));
            $sheet->setCellValue('G' . $row, $product->updated_at->format('d/m/Y H:i'));
            
            // Style cho trạng thái
            $sheet->getStyle('E' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($statusColor));
            
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
        
        $sheet->getStyle('A2:G' . ($row - 1))->applyFromArray($dataStyle);
        
        // Căn chỉnh cột
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        
        // Căn giữa cho cột số
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D:D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Wrap text cho cột tên sản phẩm
        $sheet->getStyle('B:B')->getAlignment()->setWrapText(true);
        
        // Tạo file
        $writer = new Xlsx($spreadsheet);
        $filename = 'inventory_report_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = storage_path('app/public/exports/' . $filename);
        
        // Tạo thư mục nếu chưa có
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $writer->save($filepath);
        
        return $filepath;
    }
}
