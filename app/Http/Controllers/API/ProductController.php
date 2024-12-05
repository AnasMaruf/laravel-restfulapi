<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){
        $query = Auth::user()->products();
        if (!is_null(request()->search)) {
            $query->where('name', 'like', '%'.request()->search.'%');
        }
        $products = $query->paginate(request()->per_page);
        $products->getCollection()->transform(function ($item) {
            $response = $item->api_response;
            return $response;
        });
        return ResponseFormatter::success($products);
    }

    public function store(){
        $validator = \Validator::make(request()->all(), $this->getValidation());
        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $product = Auth::user()->products()->create($this->prepareData());
        return $this->show($product->id);
    }
    public function show(int $id){
        $product = Auth::user()->products->where('id', $id)->firstOrFail();
        return ResponseFormatter::success($product->api_response);
    }
    public function update(int $id){
        $validator = \Validator::make(request()->all(), $this->getValidation());
        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }
        $product = Auth::user()->products()->where('id', $id)->firstOrFail();
        if (!is_null(request()->image)) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        }
        $product->update($this->prepareData());

        return $this->show($product->id);
    }
    public function destroy(int $id){
        $product = Auth::user()->products()->where('id', $id)->firstOrFail();
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return ResponseFormatter::success([
            'is_deleted' => 'true'
        ]);
    }

    protected function getValidation(){
        return [
            'name' => 'required|min:2|max:20',
            'description' => 'required|max:200',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ];
    }

    protected function prepareData(){
        $payload = [
            'name' => request()->name,
            'description' => request()->description,
            'price' => request()->price,
        ];
        if (!is_null(request()->image)) {
            $payload['image'] = request()->file('image')->store('product-image', 'public');
        }
        return $payload;
    }
}
