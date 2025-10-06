<?php

namespace App\Exports;

use App\Models\Review;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReviewsExport
{
    public function export(): array
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'BÁO CÁO ĐÁNH GIÁ');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = 3;
        $sheet->setCellValue('A' . $row, 'DANH SÁCH ĐÁNH GIÁ');
        $sheet->mergeCells('A' . $row . ':G' . $row);
        $this->styleHeader($sheet, 'A' . $row . ':G' . $row, 'FFF9C4', 'F57F17');

        $row++;
        $headers = ['STT', 'Sản phẩm', 'Khách hàng', 'Email', 'Rating', 'Bình luận', 'Ngày'];
        $col = 'A';
        foreach ($headers as $h) { $sheet->setCellValue($col.$row, $h); $this->styleHeader($sheet, $col.$row, 'FFF9C4', 'F57F17'); $col++; }

        $reviews = Review::with(['user','product'])->latest()->get();
        $index = 1;
        foreach ($reviews as $review) {
            $row++;
            $sheet->setCellValue('A'.$row, $index++);
            $sheet->setCellValue('B'.$row, $review->product->name ?? '');
            $sheet->setCellValue('C'.$row, $review->user->name ?? '');
            $sheet->setCellValue('D'.$row, $review->user->email ?? '');
            $sheet->setCellValue('E'.$row, $review->rating);
            $sheet->setCellValue('F'.$row, $review->comment);
            $sheet->setCellValue('G'.$row, $review->created_at->format('d/m/Y H:i'));
            $sheet->getStyle('A'.$row.':G'.$row)->applyFromArray(['borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'BDBDBD']]]]);
            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        foreach (range('A','G') as $c) { $sheet->getColumnDimension($c)->setAutoSize(true); }

        $writer = new Xlsx($spreadsheet);
        $name = 'bao-cao-danh-gia-'.date('d-m-Y').'.xlsx';
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


