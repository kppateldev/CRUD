<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use Artisan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {   
        $orders = Order::orderBy('id','ASC')->paginate(10);
        return view('admin.index', compact('orders'));
    }

    public function create()
    {
        $users = User::orderBy('id','ASC')->get();
        return view('admin.create', compact('users'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'username' => 'required',
            'grand_total' => 'required',
        ]);
        
        $order = array(
			'user_id' =>$request->username,
			'grand_total' =>$request->grand_total,
		);
        $orderid = Order::create($order)->id;
        if(isset($request->name) && !empty($request->name))
        {
            $nameArr = $request->name;
            $qtyArr = $request->qty;
            $amountArr = $request->amount;
            $totalArr = $request->total;
            if(isset($nameArr) && !empty($nameArr)):
				foreach ($nameArr as $key => $value) {
                    if(isset($value) && !empty($value)){
                        $productdata = new Product();
                        $productdata->order_id = $orderid;
                        $productdata->name = isset($nameArr[$key]) ? $nameArr[$key] : 0;
                        $productdata->qty = isset($qtyArr[$key]) ? $qtyArr[$key] : 0;
                        $productdata->amount = isset($amountArr[$key]) ? $amountArr[$key] : 0;
                        $productdata->total = isset($totalArr[$key]) ? $totalArr[$key] : 0;
                        $productdata->save();
                    }
				}
			endif;
        }
        return redirect()->route('admin.orders')->with('success','Order has been created successfully.');
    }
    public function show($id)
    {
        $data['order'] = Order::where('id',$id)->first();
        $data['products'] = Product::where('order_id',$id)->orderBy('id','ASC')->get();
        return view('admin.show',compact('data'));
    }



}
