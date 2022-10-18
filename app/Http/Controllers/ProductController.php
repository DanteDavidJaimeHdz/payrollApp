<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProduct(Request $request){
        try {
            $name = $request->get("name", null);
            $description = $request->get("description", null);
            $price = $request->get("price", null);
            $category_id = $request->get("category_id", null);
            $img = $request->get("category_id", null);
            Product::insert([
              'name' => $name,
              'description' => $description,
              'category_id' => $category_id,
              'price' => $price,
              'img' => $img
            ]);

            $response['message'] = "$name guardado correctamente";
            $response['success'] = true;
            return $response;
        }
        catch (Exception $e) {
            $response['message'] = "Ocurrió un error al guardar $name";
            $response['success'] = false;
            $response['exception'] = $e->getMessage();
            return $response;
        }


      }

      public function getListSelect($filter){
        $data = Product::select('id', 'name')->where("status",1);
        if ($filter != null || $filter != '') {
          $data->where('name', 'like', '%'.$filter.'%');
        }
            
        $data = $data->get();
            return $data;
      }
      public function getListProducts(){
  
        $data = Product::select('products.id','products.name','products.description', 'products.price', 'categories.name as category_name')
        ->where("status",1)
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->get();
        return $data;
      }
  
      public function available(){
        $data = Product::where("status",1)->get();
        return $data;
      }
  
      public function updateProduct(Request $request){
        // id de categoria
        $id = $request->input("id");
        // el estado de categoria
        $status = $request->input("status");
        
        if ($status == true) {
            $status = 1;
        }
        else {
            $status = 0;
        }
        Product::where("id",$id)->update([
          'status' => $status
        ]);
  
        $response['message'] = "Actualizo exitosamente";
        $response['success'] = true;
        return $response;
  
      }
}
