<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function __construct(Request $request) {
        // $this->middleware('auth:owner');

        // dd($request->route('shop'));
        $id = $request->route('shop');
        if(!is_null($id)) {
            // $shopsOwnerId = Shop::findOrFail($id)->owner->id;
            if(Auth::id() !== intval($id)) {
                abort(404); }
        }
    }

    public function index() {
        // $owner_id = Auth::id();
        $shops = Shop::where('owner_id',Auth::id())->get();

        return view('owner.shops.index',compact('shops'));
    }

    public function edit($id) {
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit',compact('shop'));
    }

    public function update(Request $request,$id) {
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid()) {
            Storage::putFile('public/shops',$imageFile);
        }

        return to_route('owner.shops.index');
    }
}
