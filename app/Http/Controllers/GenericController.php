<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Helpers\Http;

#use App\Exports\RolesExport;
use App\Models\Roles;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Imports\RolesImport;
use Maatwebsite\Excel\Facades\Excel;


class GenericController extends Controller
{


    /**
     * @Description: Export resource Roles to Excel
     */
    public function export()
    {

        $roles = Roles::all();
        $spreadsheet = new Spreadsheet();
        // default type and size font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(8);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc');

        // change size font for headers
        $sheet->getStyle('A1:B1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Rol');

        $i = 2;


        // print data content
        foreach ($roles as $x) {
            $sheet->setCellValue('A' . $i, $x['id']);
            $sheet->setCellValue('B' . $i, $x['rol_nombre']);
            $i++;
        }


        // adjust auto width for all content
        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }


        // download file

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte_Excel.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    }


    public function fileImport(Request $request)
    {

        try {
            Excel::import(new RolesImport, $request->file('file'));
            return Http::respuesta(Http::retOK, "Datos importados Correctamente");
        } catch (\Exception $e) {

            return Http::respuesta(Http::retError, "Error al Importar datos");
        }
    }
}