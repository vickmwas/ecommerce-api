<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getProducts(Request $request)
    {
        return Product::with('merchant')->get();
    }

    public function getMerchantProducts(Request $request)
    {
        $user = auth()->user();

        return Product::with('merchant')->where('user_id', $user->id)->get();
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'categories' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'image' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();


        $product = Product::create(array_merge(
            $validator->validated(),
            ['user_id' => $user->id]
        ));

        if ($product) {
            return response()->json([
                'message' => 'Product successfully created',
                'product' => $product,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Product creation failed',
                'data' => $request->all(),
            ], 400);
        }
    }

    public function editProduct(Request $request)
    {
        return $request;
    }
    
    //Sample Edit Method
    public function editProductNewMethod(Request $request)
    {
        return $request;
    }

    public function uploadImage(Request $request)
    {
       
        $image = $request->image;  // your base64 encoded

        $img = preg_replace('/^data:image\/\w+;base64,/', '', $image);
        $type = explode(';', $image)[0];
        $type = explode('/', $type)[1]; // png or jpg etc
        
        $imageName = Str::random(10).'.'.$type;
        $path = storage_path('app/public'). '/' . $imageName;
        
        \File::put($path, base64_decode($img));
       
        return response()->json([
            'message' => 'Image Upload Successful',
            'image_url' => url('storage/'.$imageName)
        ], 201);
    }
}
