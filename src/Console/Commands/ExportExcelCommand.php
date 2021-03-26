<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command export record as excel file';

    /**
     * The
     *
     * @var
     */
    private $spreadsheet;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sheet = $this->spreadsheet->getActiveSheet();


        $orders = DB::table('orders')
            ->rightJoin('order_has_payments', 'orders.id', '=', 'order_has_payments.order_id')
            ->get();

        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NOMOR_ORDER');
        $sheet->setCellValue('C1', 'TANGGAL_ORDER');
        $sheet->setCellValue('D1', 'ASAL');
        $sheet->setCellValue('E1', 'TUJUAN');
        $sheet->setCellValue('F1', 'PENUMPANG');
            $sheet->setCellValue('F2', 'NAMA');
            $sheet->setCellValue('G2', 'KTP');
            $sheet->setCellValue('H2', 'KODE_BOOKING');
            $sheet->setCellValue('I2', 'KODE_TIKET');
            $sheet->setCellValue('J2', 'TEMPAT_DUDUK');
            $sheet->setCellValue('K2', 'HARGA_TIKET');
            $sheet->setCellValue('L2', 'PCS');
            $sheet->setCellValue('M2', 'HARGA_CEK_COVID');
            $sheet->setCellValue('N2', 'TOTAL');
        $sheet->setCellValue('O1', 'TOTAL_BAYAR');
        $sheet->setCellValue('P1', 'METODE_BAYAR');
        $sheet->setCellValue('Q1', 'STATUS_BAYAR');
        $sheet->setCellValue('R1', 'TANGGAL_BERANGKAT');
        $sheet->setCellValue('S1', 'JAM_BERANGKAT');
        $sheet->setCellValue('T1', 'NOMOR_PENERBANGAN');
        $sheet->setCellValue('U1', 'PESAWAT');

        $i = 1;
        $col = 3;
        foreach ($orders as $order) {
            $schedule = DB::table('schedules')
                ->where('id', $order->schedule_id)
                ->first();

            $routes = DB::table('routes')
                ->where('schedule_id', $schedule->id)
                ->first();

            $airplane =  DB::table('airplanes')
                ->where('id', $schedule->airplane_id)
                ->first();

            $airline = DB::table('airlines')
                ->where('id', $airplane->airline_id)
                ->first();

            $order_items = DB::table('order_items')
                ->join('passengers', 'order_items.passenger_id', '=', 'passengers.id')
                ->join('airplane_has_sheets', 'airplane_has_sheets.id', '=', 'order_items.sheet_id')
                ->where('order_id', $order->id)
                ->get(['order_items.*', 'passengers.*', 'airplane_has_sheets.name as sheet_name']);

            $sheet->setCellValue("A${col}", $i);
            $sheet->setCellValue("B${col}", $order->number);
            $sheet->setCellValue("C${col}", $order->date);
            $sheet->setCellValue("D${col}", $schedule->origin);
            $sheet->setCellValue("E${col}", $schedule->destination);

            foreach ($order_items as $item) {
                $sheet->setCellValue("F${col}", $item->name);
                $sheet->setCellValue("G${col}", $item->identity_number);
                $sheet->setCellValue("H${col}", $item->booking_code);
                $sheet->setCellValue("I${col}", $item->ticket_code);
                $sheet->setCellValue("J${col}", $item->sheet_name);
                $sheet->setCellValue("K${col}", $item->price);
                $sheet->setCellValue("L${col}", $item->pcs);
                $sheet->setCellValue("M${col}", $item->c19);
                $sheet->setCellValue("N${col}", $item->total);
                $col++;
            }

            $sheet->setCellValue("O${col}", $order->total_price);
            $sheet->setCellValue("P${col}", $order->method);
            $sheet->setCellValue("Q${col}", $order->status);
            $sheet->setCellValue("R${col}", $schedule->flight_date);
            $sheet->setCellValue("S${col}", $routes->depart_time);
            $sheet->setCellValue("T${col}", $schedule->flight_number);
            $sheet->setCellValue("U${col}", "$airplane->manufacture $airline->callsign");

            $i++;
            $col++;
        }

        $writer = new Xlsx($this->spreadsheet);
        $writer->save('tiket_export'.Carbon::now().'.xlsx');
    }
}
