<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{

    public function __construct(Request $request) {
        $id = $request->route()->parameter('item');

        if(!is_null($id)) {
            $itemId = Product::availableItems()->where('products.id',$id)->exists();
            if(!$itemId) {
                abort(404);
            }
        }
    }

    public function index(Request $request) {
        // $products = Product::availableItems()->get();
        $products = Product::availableItems()
        ->sortOrder($request->sort)
        ->paginate($request->pagination);
        // dd($products);
        return view('user.index',compact('products'));
    }

    public function show($id) {
        $product = Product::findOrFail($id);

        $quantity = Stock::where('product_id',$product->id)->sum('quantity');
        if($quantity > 9) {
            $quantity = 9;
        }
        return view('user.show',compact('product','quantity'));
    }
}
