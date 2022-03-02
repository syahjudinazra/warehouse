<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use App\Proyek;
 
use App\Exports\ProyekExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
 
class ProyekController extends Controller
{
	public function index()
	{
		$proyek = Proyek::all();
		return view('proyek',['proyek'=>$proyek]);
	}
 
	public function export_excel()
	{
		return Excel::download(new ProyekExport, 'proyek.xlsx');
	}
}