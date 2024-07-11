<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
    }

    public function update(Request $request) {
        
    }
}
