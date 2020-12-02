<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Product;
use App\Models\Category;
use Str;
class ImportProduct implements ToModel, WithStartRow, WithMultipleSheets,WithValidation
{
    use Importable;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
       
        $destinationPath    = 'assets/uploads/product/';
        $image_name = Str::slug(substr($row[0], 0, 30));
        $ext = pathinfo($row[3], PATHINFO_EXTENSION);
       
        if($row[3])
        {
            
            $file       = $row[3];
            $ext = pathinfo($row[3], PATHINFO_EXTENSION);
            $fileName   = value(function() use ($file, $image_name,$ext)
            {
              $newName = $image_name.'-'.Str::random(5) . '.' . $ext;
              return strtolower($newName);
            });

            $oldPath = $row[3] ;
            $newPath = $destinationPath.$fileName ;
            if (\File::copy($oldPath , $newPath)) {
                
            }            
            $img = \Image::make($destinationPath.$fileName);
            $img->resize(264, 264);
            $img->save('assets/uploads/product/thumb/'.$fileName);
        }
        
        $category = Category::where('id',$row[4] )->first();

        if(!empty($category)) {
            $category_id = $category->id;

        } else {
            $category_id = '';;
        }

    
        $Product  = new Product;
        $Product->title  = $row[0];
        $Product->description    = $row[1];
        $Product->price         = $row[2];
        $Product->category_id        = $category_id;
        $Product->img        = $fileName;
        $Product->save();
        return $Product;

          
    }
    public function sheets(): array
    {
        return [
            // Select by sheet index
            0 => new ImportProduct(),
        ];
    }

    public function rules(): array
    {
        return [
           
               '2' => 'required',
             
        ];
    }

   
     public function startRow(): int
    {
        return 2;
    }
    
}
