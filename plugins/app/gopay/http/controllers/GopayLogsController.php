<?php

namespace App\Gopay\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Gopay\Models\GopayLogs;

class GopayLogsController extends Controller
{
    /**
     * Zobrazenie všetkých logov GoPay.
     */
    public function index()
    {
        $logs = GopayLogs::all();

        return response()->json($logs);
    }

    /**
     * Zobrazenie konkrétneho logu podľa ID.
     */
    public function show($id)
    {
        $log = GopayLogs::find($id);

        if (!$log) {
            return response()->json(['error' => 'Log not found'], 404);
        }

        return response()->json($log);
    }
}
