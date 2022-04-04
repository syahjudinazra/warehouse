<?php

namespace App\Exports;

use App\model\stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelExport implements FromView
{
    public function view(): View
    {
        return view('stock_history', [
            'stock' => stock::all()
        ]);
    }
}
