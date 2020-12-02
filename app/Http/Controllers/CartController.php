<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
//use Cart;
use Auth;
use Session;
class CartController extends Controller
{
    public function Addtocart(Request $request)
  {
      //Cart::destroy();

      //Session::forget('cart');
      $getProduct = Product::where('id',$request->product_id)->first();
      $cart = Session::get('cart');
      $cart[$getProduct->id] = array(
        "id" => $getProduct->id,
        "title" => $getProduct->title,
        "price" => $getProduct->price,
        "qty" => 1,

    );

       Session::put('cart', $cart);
       if($cart)
        {
            $data = [
                'type'      => 'success',
            ];
            return response()->json($data, 200);
        }
        else {
          $data = [
                'type'      => 'error',
                'message'   => 'something went wrong. please try again.',
            ];
            return response()->json($data, 200);

        }
  }
  public function viewcart()
  {
    $cart = Session::get('cart');
    return view('viewcart')->with('data',$cart);
    // return view('checkout')->with('data',$cart);
  }
  public function itemremove($id)
  {
      if($id) {

            $cart = Session::get('cart');
             //dd($cart[$id]);

            if(isset($cart[$id])) {

                unset($cart[$id]);

                Session::put('cart', $cart);
            }

           notify()->success('Success, Remove Successfully.');

        }
       return redirect()->back();
  }
    public function updateCart(Request $request)
  {
    
    //$cart = Session::forget('cart');
    $cart = Session::get('cart');
    if(!$cart){
    $cart = new Cart($cart);
    }

    $i = 0;
    $data =[];
    foreach($cart as $key => $showdata){
  
        $qty = $request->input($showdata['id']);
        $showdata['id']     = $showdata['id'];
        $showdata['title']  = $showdata['title'];
        $showdata['price']  = $showdata['price'];
        $showdata['qty']    = $qty;
        $i++;
        $data[$showdata['id']] = $showdata;
    }
    //dd($data);
  
   
     Session::put('cart', $data);
    notify()->success('Success, Update Cart Successfully.');
    return redirect()->back();
  }

  public function checkout()
  {
      $cart = Session::get('cart');
      return view('checkout')->with('data',$cart);
  }
}
