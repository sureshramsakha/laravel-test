<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class ProductController extends Controller
{
    public function index() {
		return view('products');
	}
	
	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
            'name' 		=> 'required|string|max:255',
            'quantity' 	=> 'required|integer|min:0',
            'price' 	=> 'required|numeric|gt:0',
        ]);
		
		if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()]);
        } else {
			$data = $this->get_data();
				
			$product_id = $this->get_new_product_id();
							
			$data['products'][] = ['id' => $product_id, 'name' => $request->name, 'quantity' => $request->quantity, 'price' => $request->price, 'created_at' => date('Y-m-d H:i:s')];
			
			$path = $this->get_file_path();
			File::put($path, json_encode($data, JSON_PRETTY_PRINT));
			
			$message = 'Product saved successfully!';
			
			return response()->json(['status' => 1, 'message' => $message]);
		}
	}
	
	function get_listing() {
		$data = $this->get_data();		
		$products 	= isset($data['products']) ? collect($data['products'])->sortBy('created_at') : [];
		
		return response()->json([
			'html' => view('listing', compact('products'))->render()
		]);
	}
	
	function get_file_path() {
		$path = storage_path('app/public/products.json');

		if (!File::exists($path)) {
			File::put($path, 'This is a new file.');
		}
		
		return $path;
	}
	
	function get_data() {
		$path = $this->get_file_path();
		$json = File::get($path);
		$data = json_decode($json, true);	
		return $data;
	}
	
	function get_new_product_id() {
		$data = $this->get_data();
		
		$product_id = 1;
		if(isset($data['products']) && count($data['products'])) {			
			$products 	= array_column($data['products'], 'name', 'id');			
			$product_id = max(array_keys($products)) + 1;
		}
		
		return $product_id;
	}
}
