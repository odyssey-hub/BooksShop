<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index()
    {
        $Agenres = DB::table('products')
            ->selectRaw('products.genres,SUM(order_sku.count) as count')
            ->join('skus', 'skus.product_id', '=', 'products.id')
            ->join('order_sku', 'order_sku.sku_id', '=', 'skus.id')
            ->groupBy("genres")
            ->get();

        $Ayears = DB::table('skus')
            ->selectRaw('skus.year,SUM(order_sku.count) as count')
            ->join('order_sku','skus.id','=','order_sku.sku_id')
            ->groupBy('year')
            ->get();

        $Aprices = DB::table('skus')
            ->selectRaw('skus.price,SUM(order_sku.count) as count')
            ->join('order_sku','skus.id','=','order_sku.sku_id')
            ->groupBy('price')
            ->get();

//        app('debugbar')->info($test);

        return view('auth.analysis.index',compact('Agenres', 'Ayears','Aprices'));
    }
}
