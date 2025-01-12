<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        Mail::to('test@example.email')
        ->send(new TestMail());
        // $products = Product::availableItems()->get();
        $products = Product::availableItems()
        ->selectCategory($request->category?? '0')
        ->searchKeyword($request->keyword)
        ->sortOrder($request->sort)
        ->paginate($request->pagination ?? '20');
        // dd($products);

        $categories = PrimaryCategory::with('secondary')->get();

        return view('user.index',compact('products','categories'));
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
