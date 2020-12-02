<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Validator;
use URL;
use Session;
use Redirect;
use DB;
use Auth;
use Softon\Indipay\Facades\Indipay;
use Illuminate\Support\Facades\Config;
class PaymentController extends Controller
{


	 public function __construct(Request $request)
    { 
       
        Config::set('indipay.gateway', 'PayUMoney');
        Config::set('indipay.PayUMoney.merchantKey', env('INDIPAY_MERCHANT_KEY'));
        Config::set('indipay.PayUMoney.salt', env('INDIPAY_SALT'));
            
         
    }


  public function  paymentSystem() {
  	$allproduct = Product::get();
    return View('bur-products')->with('allproduct', $allproduct);
  }


   public  function makePayment(Request $request)
   {
       
  
        $cart =  Session::get('cart');
        if($cart) {
            $total = 0;
            foreach($cart as $addItem)
            {
                $price = number_format((float)$addItem['price'], 2, '.', '');
                $getPrName = Product::where('id', $addItem['id'])->first();
                $total += $price*$addItem['qty'];
    
            }
            $subTotal = number_format((float)$total, 2, '.', '');
            $taxAmount =  ($total*18)/100;
            $tax = number_format((float)$taxAmount, 2, '.', '');
            $amountTotal = $subTotal+ $tax;
            $finalAmount =  number_format((float)$amountTotal, 2, '.', '');


            
        }
            $parameters = [
                'firstname' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->mobile,
                'productinfo' =>'Products',
                'service_provider' => 'payu_paisa',
                'amount' => $finalAmount,
            ];
            $order = Indipay::prepare($parameters);
            return Indipay::process($order);
    }
 
    
    
  
}
