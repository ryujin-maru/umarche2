<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Owner;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(Request $request) {
        $id = $request->route('product');
        if(!is_null($id)) {
            $productId = Product::findOrFail($id)->shop->owner->id;
            if(Auth::id() !== intval($productId)) {
                abort(404); }
        }
    }

    public function index()
    {
        $ownerInfo = Owner::with('shop.product.imageFirst')->where('id',Auth::id())->get();
        return view('owner.products.index',compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shops = Shop::where('owner_id',Auth::id())->select('id','name')->get();

        $images = Image::where('owner_id',Auth::id())->select('id','title','filename')->orderBy('updated_at','desc')->get();

        $categories = PrimaryCategory::with('secondary')->get();

        return view('owner.products.create',compact('shops','images','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
