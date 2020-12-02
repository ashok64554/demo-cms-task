<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\User;
use App\Models\Product;
use Google;
use Auth;
class SheetController extends Controller
{
    public function importSheet(Request $request)
    {
      	if($request->submit =='import') {
	        $values = Sheets::spreadsheet($request->post_spreadsheet_id)->sheet($request->post_spreadsheet_name)->get();
	        $header = $values->pull(0);
			$values = Sheets::collection($header, $values);
			$values->toArray();

			foreach ($values as $key => $row) {
				
				$product = New Product;
				$product->title = $row['title'];
				$product->description = $row['description'];
				$product->price = $row['price'];
				$product->img  = $row['img'] ;
				$product->category_id  = $row['category_id'] ;
				$product->save();
			}

			return redirect()->back()->with('success','Added successfully.');
		} else {

			$append = Product::get()->toArray();

			Sheets::spreadsheet($request->post_spreadsheet_id)->sheet($request->post_spreadsheet_name)->append([['title' => 'name4', 'description' => 'mail4', 'price' => 4,'img' => '4.jpg', 'category_id' => 2]]);
			$values = Sheets::all();


			dd($values);
			return redirect()->back()->with('success','Export successfully.');
		}
		

    }


     
}
