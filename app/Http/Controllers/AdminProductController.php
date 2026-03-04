<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    //todo
    // create new product
    public function createProduct (Request $resquest){
        $resquest -> validate([
            'product_name' => 'required|string',
            'category_id' => 'required|integer|exists:categories,category_id',
            'product_stocks' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'isSale' => 'boolean',
        ]);
        
        $product = Product::create([
            'product_name' => $resquest->product_name,
            'category_id' => $resquest->category_id,
            'product_stocks' => $resquest->product_stocks,
            'description' => $resquest->description,
            'price' => $resquest->price,
            'isSale' => $resquest->isSale ?? false, 
        ]);
        
        if(!$product){
            return response()->json(['message' => 'Failed to create product'], 500);
        }

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }   
    // Show all products to admin

    public function showProducts(){
        $products = Product::with('category', 'images')->get();
        return response()->json($products);
    }
    
    // Update product details
    public function updateProduct(Request $request, $id){
        $request -> validate([
            'product_name' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|string',
            'product_stocks' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'isSale' => 'sometimes|boolean',
            
        ]);
        
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        $product->update($request->only([
            'product_name',
            'category_id',
            'product_stocks',
            'description',
            'price',
            'isSale'
        ]));
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);

    }
    // Delete a product
    public function deleteProduct($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
