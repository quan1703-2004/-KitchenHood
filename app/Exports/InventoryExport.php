<?php

namespace App\Exports;

use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InventoryExport
{
    public function export(): array
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'BÁO CÁO TỒN KHO');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 3;
        $sheet->setCellValue('A' . $row, 'DANH SÁCH SẢN PHẨM');
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $this->styleHeader($sheet, 'A' . $row . ':F' . $row, 'E3F2FD', '0D47A1');

        $row++;
        $headers = ['STT', 'ID', 'Tên sản phẩm', 'Danh mục', 'Giá', 'Số lượng tồn'];
        $col = 'A';
        foreach ($headers as $h) { $sheet->setCellValue($col.$row, $h); $this->styleHeader($sheet, $col.$row, 'E3F2FD', '0D47A1'); $col++; }

        $products = Product::with('category')->orderBy('quantity', 'asc')->get();
        $index = 1;
        foreach ($products as $p) {
            $row++;
            $sheet->setCellValue('A'.$row, $index++);
            $sheet->setCellValue('B'.$row, $p->id);
            $sheet->setCellValue('C'.$row, $p->name);
            $sheet->setCellValue('D'.$row, $p->category->name ?? '');
            $sheet->setCellValue('E'.$row, number_format($p->price) . '₫');
            $sheet->setCellValue('F'.$row, $p->quantity);
            $sheet->getStyle('A'.$row.':F'.$row)->applyFromArray(['borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'BDBDBD']]]]);
            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        foreach (range('A','F') as $c) { $sheet->getColumnDimension($c)->setAutoSize(true); }

        $writer = new Xlsx($spreadsheet);
        $name = 'bao-cao-ton-kho-'.date('d-m-Y').'.xlsx';
        $tmp = tempnam(sys_get_temp_dir(), $name);
        $writer->save($tmp);
        return ['file'=>$tmp,'name'=>$name];
    }

    private function styleHeader($sheet, $range, $bg, $fg): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>$bg]],
            'font'=>['bold'=>true,'color'=>['rgb'=>$fg]],
            'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER,'vertical'=>Alignment::VERTICAL_CENTER]
        ]);
        $sheet->getStyle($range)->applyFromArray(['borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'BDBDBD']]]]);
    }
}
