<?php

namespace App\Exports;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductsExport implements FromCollection,WithHeadings
{
	use Exportable;

	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	
    	$products = Product::with('category')->get();

		return $array = $products->map(function ($b, $key) {
		return [
		'title' 		=> $b->title,
		'description' 	=> $b->description,
		'price' 		=> $b->price,
		'img' 			=> url('assets/uploads/product/'.$b->img.''),
		'rating' 		=> $b->rating,
		'created_at' 	=> $b->created_at,
		];
		});
        
    }

    public function headings(): array {
	    return [
	      'title',
	      'description',
	      'price',
	      'img',
	      'category_id',
	      'rating',
	      'created_at',
	     ];
	  }
}
