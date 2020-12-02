<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\User;
use App\Models\Product;
use App\Models\Benefit;
use App\Models\ReceiveOption;
use App\Http\Resources\BoxResource;
use Str;
use DB;
use Auth;
class BoxController extends Controller
{
   public function boxes()
	{
        if(Auth::user()->roles[0]->name =='admin') {
		  $boxes  = Box::orderBy('id','DESC')->get();
        } else {
          $boxes  = Box::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
		return view('admin.box',compact('boxes'));
	}

	public function addbox()
	{
		$allProduct = Product::get();
		$allBenifites = Benefit::get();
		$ReceiveOption = ReceiveOption::pluck('period','id')->all();
        $boxProduct  =[];
        $boxBenifits  =[];
		return view('admin.box',compact('allProduct','allBenifites','ReceiveOption','boxProduct','boxBenifits'));	
	}

	public function editbox($id)
	{
		$allProduct = Product::get();
		$allBenifites = Benefit::get();
		$ReceiveOption = ReceiveOption::pluck('period','id')->all();

        $boxProduct = DB::table("box_product")->where("box_product.box_id",$id)
            ->pluck('box_product.product_id','box_product.product_id')
            ->all();
        $boxBenifits = DB::table("benefit_box")->where("benefit_box.box_id",$id)
            ->pluck('benefit_box.benefit_id','benefit_box.benefit_id')
            ->all();
        
		$box = Box::where('id', $id)->first();
		return View('admin.box',compact('box','allProduct','allBenifites','ReceiveOption','boxProduct','boxBenifits'));
	}


	public function savebox(Request $request)
	{    
		$this->validate($request, [  
			'name' => 'required|string',
            'description' => 'required|string',
            'benefitIds' => 'required|array',
            'products' => 'required|array',
            'resubscribePeriod' => 'required|string',
        ]); 
		
		if(!empty($request->id)) 
		{
			$box = Box::find($request->id);
		}
		else 
		{
			$box  = new Box;
		}
		$destinationPath    = 'assets/uploads/box/';
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
            $img->save('assets/uploads/box/thumb/'.$fileName);
        }
        else
        {
            $fileName = $request->oldImage;
        }
		 

       
        $box->name = $request->name;
        $box->description = $request->description;
        $box->is_custom = 1;
        $box->img =$fileName ;
        $box->resubscribe_period = $request->resubscribePeriod;
        $box->user_id = auth()->id();
        $box->free_shipping_from = 900;
        $box->save();

        $box->benefits()->sync($request->benefitIds);

        if(!empty($request->id)) 
        {
            $deleteOld = DB::table("box_product")->where('box_id',$request->id)->delete();
        }
        foreach($request->products as $product) {
           
            $box->products()->attach([$product => ['count' => '2']]);
        }

       
		if(empty($request->id)) {
			return redirect()->route('box')->with('success','box added successfully');
		}
		elseif(!empty($request->id)) {
			return redirect()->route('box')->with('success','box updated successfully');
		}
	}

    public function assigneBoxId(Request $request)
    {
        
        $allUsers = User::where('UserType','!=','admin')->pluck('name', 'id')
            ->all();
        $allBoxes = Box::pluck('name', 'id')
            ->all();
        return view('admin.assigne_boxid', compact('allBoxes', 'allUsers'));
    }
    public function saveAssigneBox(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'box_id' => 'required|numeric',
        ]);

        $boxOrigin = Box::find($request->box_id);
        $box = new Box();
        $box->name = $boxOrigin->name;
        $box->description = $boxOrigin->description;
        $box->img = $boxOrigin->img;
        $box->is_custom = 1;
        $box->resubscribe_period = $boxOrigin->resubscribe_period;
        $box->user_id = $request->user_id;
        $box->free_shipping_from = $boxOrigin->free_shipping_from;
        $box->save();
        $allbenifits = DB::table("benefit_box")->where('box_id',$request->box_id)->pluck('benefit_id','benefit_id')->all();
        $box->benefits()->sync($allbenifits);

        $allProducts = DB::table("box_product")->where('box_id',$request->box_id)->pluck('product_id','product_id')->all();
        foreach($allProducts as $product) {
            $box->products()->attach([$product => ['count' => '2']]);
        }

        return redirect()->route('box')->with('success','Assigne Box  successfully');
    }
}
