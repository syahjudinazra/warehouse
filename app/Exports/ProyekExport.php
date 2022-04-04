<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProyekExport implements FromView
{
    public function view(): View
    {
        $history = DB::table('stock')
                    ->leftJoin("products", "stock.product_id", "=", "products.product_id")
                    ->leftJoin("shelf", "stock.shelf_id", "=", "shelf.shelf_id")
                    ->leftJoin("users", "stock.user_id", "=", "users.id")
                    ->select("stock.*", "products.product_code", "products.product_name", "shelf.shelf_name", "users.name")
                    ->orderBy("stock.stock_id", "desc");

        return view('export_history', [
            'history' => $history->get()
        ]);
    }
}
