<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @method productTotals
     * @author Dante Jaime
     * @description método que trae el total de productos registrados
     */
    public function productTotals() {
        return $total = Product::select('id')->count();
    }
    /**
     * @method earningsOfWeek
     * @author Dante Jaime
     * @description método que obtiene las ganancias de la semana (últimos 7 días)
     */

     public function earingsOfWeek() {
        $from = Carbon::now();
        $to = Carbon::now()->subDays(7);
        $orders = Order::select(DB::raw('sum(products.price) as total'))
                    ->join('order_products', 'order_products.order_id', '=', 'orders.id')
                    ->join('products', 'order_products.product_id', '=' ,'products.id')
                    ->whereBetween('orders.created_at', [$from, $to]);
        return $orders;
     }
}
