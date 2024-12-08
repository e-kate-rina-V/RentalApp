<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateMonthlyReportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function generateReport(Request $request): JsonResponse
    {
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        dispatch(new GenerateMonthlyReportJob($startDate, $endDate, Auth::id()));

        return response()->json([
            'message' => 'Отчет генерируется. Ожидайте уведомления.',
        ], 202);
    }

    public function downloadReportFromStorage(string $fileName)
    {
        $path = 'reports/' . $fileName;

        if (!Storage::exists($path)) {
            return response()->json(['error' => 'Отчет не найден'], 404);
        }

        $fileUrl = Storage::url($path);

        return response()->json([
            'fileUrl' => $fileUrl,  
        ]);
    }
}
