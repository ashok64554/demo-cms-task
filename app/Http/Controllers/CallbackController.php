<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\ProductOrder;
use Validator;
use URL;
use Session;
use Redirect;
use DB;
use Auth;
use Str;
use Softon\Indipay\Facades\Indipay;
class CallbackController extends Controller
{
     public function sucess()
    {
       $cart = Session::forget('cart');
        
        return view('paymentdone');
    }
    public function failed()
    {	
       $cart = Session::forget('cart');
       
        return view('paymentFailed');
    }


    public function response(Request $request)
    
    {

        $response = Indipay::response($request);
            //dd($request);
        if ($request->status== 'success') {

           
            $cart =  Session::get('cart');
            $total =0;
            foreach($cart as $addItem)
                {
                    $price = number_format((float)$addItem['price'], 2, '.', '');
                    $total += $price*$addItem['qty'];

                }
            $subTotal = number_format((float)$total, 2, '.', '');
            $taxAmount =  ($total*18)/100;
            $tax = number_format((float)$taxAmount, 2, '.', '');

            $orderDetail = new OrderDetail;
            $orderDetail->user_id =Auth::id();
            $orderDetail->random_string =Str::random(10);
            $orderDetail->amount =$request->amount;
            $orderDetail->total =$subTotal;
            $orderDetail->tax_per =18;
            $orderDetail->tax_amount =$tax;
            $orderDetail->paymentMethod ='PayU';
            $orderDetail->ip_address = $request->ip();
            $orderDetail->orderstatus = 'approved';
            $orderDetail->save();
            foreach($cart as $addItem)
                {
                    $price = number_format((float)$addItem['price'], 2, '.', '');
                   
                    $productOrder = new ProductOrder;
                    $productOrder->order_id = $orderDetail->id;
                    $productOrder->product_id = $addItem['id'];
                    $productOrder->qty = $addItem['qty'];
                    $productOrder->price = $price;
                    $productOrder->save();

                }
            notify()->success('Success, Payment success.');
            return Redirect::route('get-payment-status');
            } else {
            notify()->error('Payment cancel.');
            return Redirect::route('get-payment-status-failed');
            }

    } 


   
     
}
