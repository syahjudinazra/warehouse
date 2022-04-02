<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\model\stock;

use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function index()
	{
		$stock = stock::all();
		return view('stock',['stock_history'=>$stock]);
	}
 
	public function export_excel()
	{
		return Excel::download(new ExcelExport, 'Report.xlsx');
	}
}
