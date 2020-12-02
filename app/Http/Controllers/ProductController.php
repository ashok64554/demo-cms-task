<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Str;
use DB;
use Auth;
use App\Imports\ImportProduct;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{
     public function products()
	{
      
		$products  = Product::orderBy('id','DESC')->get();
        
		return view('admin.product',compact('products'));
	}

	public function addproduct()
	{
	
		$categories = Category::pluck('title','id')->all();
        
		return view('admin.product',compact('categories'));	
	}

	public function editproduct($id)
	{
	
		$categories = Category::pluck('title','id')->all();
		$product = Product::where('id', $id)->first();
		return View('admin.product',compact('product','categories'));
	}


	public function saveproduct(Request $request)
	{    
		$this->validate($request, [  
			'title' => 'required|string',
			'category_id' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
        ]); 
		
		if(!empty($request->id)) 
		{
			$product = Product::find($request->id);
		}
		else 
		{
			$product  = new Product;
		}
		$destinationPath    = 'assets/uploads/product/';
        $image_name = Str::slug(substr($request->title, 0, 30));
        if($request->hasFile('image'))
        {
            if($request->oldImage!='')
            {
                if(file_exists($destinationPath.$request->oldImage)){ 
                    unlink($destinationPath.$request->oldImage);
                    unlink($destinationPath.'thumb/'.$request->oldImage);
                }
            }
            $file       = $request->image;
            $fileName   = value(function() use ($file, $image_name)
            {
              $newName = $image_name.'-'.Str::random(5) . '.' . $file->getClientOriginalExtension();
              return strtolower($newName);
            });
            $request->image->move($destinationPath, $fileName);
            $img = \Image::make($destinationPath.$fileName);
            $img->resize(264, 264);
            $img->save('assets/uploads/product/thumb/'.$fileName);
        }
        else
        {
            $fileName = $request->oldImage;
        }
		 

        $product->title = $request->title;
        $product->description = $request->description;
        $product->img =$fileName ;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();
		if(empty($request->id)) {
			return redirect()->route('products')->with('success','Product added successfully');
		}
		elseif(!empty($request->id)) {
			return redirect()->route('products')->with('success','Product updated successfully');
		}
	}

	public function deleteproduct($id)
    {
         if(Product::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $user = Product::where('id', $id)->delete();
        return redirect()->back()->with('delete','product successfully deleted.');
    }

    public function productImport(Request $request){
  		$this->validate($request,[
	      'file'          => 'required|file|mimes:csv,xlsx,xls,txt',

  		]);
  		if ($request->file('file')->isValid()) {
		    Excel::import(new ImportProduct, request()->file('file'));
        }
       return redirect()->route('products')->with('success','File Upload  successfully');

  	}

  	public function productExport(Request $request){
  		
  		return Excel::download(new ProductsExport, 'product'.date("Y-m-d").'.csv');

  	}
}
