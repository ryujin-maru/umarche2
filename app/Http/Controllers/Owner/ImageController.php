<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UploadRequest;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(Request $request) {
        $id = $request->route('image');
        if(!is_null($id)) {
            $imagesId = Image::findOrFail($id)->owner->id;
            if(Auth::id() !== intval($imagesId)) {
                abort(404); }
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::where('owner_id',Auth::id())->orderBy('updated_at','desc')->paginate(20);

        return view('owner.images.index',compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadRequest $request)
    {
        $imageFiles = $request->file('files');
        if(!is_null($imageFiles)) {
            foreach($imageFiles as $imageFile) {
                $filenameToStore = ImageService::upload($imageFile,'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $filenameToStore,
                ]);
            }
        }

        return to_route('owner.images.index')
        ->with(['message'=>'画像登録をを実施しました。','status'=>'info']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $image = Image::findOrFail($id);
        return view('owner.images.edit',compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['string', 'max:50'],
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return to_route('owner.images.index')
        ->with(['message'=>'画像情報を更新しました。','status'=>'info']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $image = Image::findOrFail($id);

        $imageInProducts = Product::where('image1',$image->id)
        ->orWhere('image2',$image->id)
        ->orWhere('image3',$image->id)
        ->orWhere('image4',$image->id)
        ->get();

        if($imageInProducts) {
            $imageInProducts->each(function($product) use($image){
                if($product->image1 === $image->id) {
                    $product->image1 = null;
                    $product->save();
                }
                if($product->image2 === $image->id) {
                    $product->image2 = null;
                    $product->save();
                }
                if($product->image3 === $image->id) {
                    $product->image3 = null;
                    $product->save();
                }
                if($product->image4 === $image->id) {
                    $product->image4 = null;
                    $product->save();
                }
            });
        }

        $filePath = 'public/products/'.$image->filename;


        if(Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete();
        return redirect()->route('owner.images.index')->with(['message'=>'画像を削除しました。','status' => 'alert']);
    }
}
