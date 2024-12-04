<?php

namespace App\Jobs;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\ReportGenerated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePdfReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {

        $data = [
   
        ];
        
        $pdf = PDF::loadView('pdf.report', $data);
        $filePath = storage_path('app/storage/reports/report.pdf');
        $pdf->save($filePath);

        $userId = 1; 

        event(new ReportGenerated($userId, $filePath));
    }
}
