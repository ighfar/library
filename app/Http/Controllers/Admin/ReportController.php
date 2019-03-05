<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Models\Category;
use App\Codes\Models\Customer;
use App\Codes\Models\Purchase;
use App\Codes\Models\PurchaseDetails;
use App\Codes\Models\Settings;
use App\Codes\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportController extends Controller
{
    protected $data;
    protected $setting;
    protected $route;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setting = Settings::pluck('value', 'key');
        $this->route = 'report';
        $this->data['setting'] = $this->setting;
        $this->data['this_route'] = $this->route;
        $this->data['this_label'] = 'Report';

    }

    public function index()
    {
        $data = $this->data;

        if($this->request->get('export')) {
            if ($this->request->get('export') == 'buku_report') {
                $this->export_buku_report();
                exit;
            }



        return view(env('ADMIN_TEMPLATE') . '.report.index', $data);
    }
}
    public function export_buku_report()
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', -1);
        $list_customer = Buku::pluck('judul', 'id')->toArray();

        $getData = Buku::query();

        $date_start = strtotime($this->request->get('date_start'));
        $date_end = strtotime($this->request->get('date_end'));


        if ($date_start && $date_end) {
            $getData = $getData->whereBetween('date', [date('Y-m-d', $date_start), date('Y-m-d', $date_end)]);
        }
           if (intval($judul) > 0) {
            $getData = $getData->where('buku.judul', '=', $judul);
        }


        $getData = $getData->orderBy('date', 'ASC')->get();

        $headers = [
            'judul' => 'Judul',
            'isbn' => 'ISBN',
            'pengarang' => 'Pengarang',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 'Tahun Terbit',
            'jumlah_buku' => 'Jumlah Buku',
            'deskripsi' => 'Deskripsi',
            'lokasi' =>  'lokasi'
        ];
        $title = 'Laporan Buku';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Library')
            ->setLastModifiedBy('Library')
            ->setTitle($title)
            ->setSubject('Laporan')
            ->setDescription('Laporan');

        $sheet = $spreadsheet->getActiveSheet();

        $column = 1;
        $row = 1;
        $sheet->setCellValueByColumnAndRow($column, $row, 'Laporan Buku dari tanggal: '.date('Y-m-d', $date_start).' - '.date('Y-m-d', $date_end));
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('center');

        $column = 1;
        $row += 2;
        foreach ($headers as $key => $header) {
            $sheet->setCellValueByColumnAndRow($column++, $row, $header);
        }

        if ($getData) {
            $total_price = 0;

            $column = 1;
            $row++;

            foreach ($getData as $list) {
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->judul);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->isbn);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->pengarang);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->penerbit);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->tahun_terbit);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->jumlah_buku);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->deskripsi);
                $sheet->setCellValueByColumnAndRow($column++, $row, $list->lokasi);

                $column = 1;
                $row++;
                
            }

            
            $sheet->mergeCells('A'.$row.':D'.$row);
            
        }

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . str_replace(' ' , '_', $title) . '_' . strtotime("now") . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }
}
