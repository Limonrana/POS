<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(16);
        $count = Product::all()->count();
        return view('pages.inventory.product.product-grid', compact('products', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category   = Category::all();
        $unit       = Unit::all();
        return view('pages.inventory.product.new-product', compact('category', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created            = Auth::user()->name;
        $validatedData      = $request->validate([
            'title'         => 'required|unique:products|max:120',
            'category_id'   => 'required|integer',
            'unit_id'       => 'required|integer',
            'code'          => 'required',
            'buying_price'  => 'required',
            'selling_price' => 'required',
        ],
            [
                'category_id.integer' => 'The category field is required',
                'unit_id.integer' => 'The unit field is required',
            ]);

        if ($request->image) {
            $getImage = $request->image;
            $makeImage = Str::random(20) . '.' . $getImage->getClientOriginalExtension();
            // resizing an uploaded file
            Image::make($getImage)->resize(898, 517)->save(public_path('uploads/' . $makeImage));
            $photo                = new Photo();
            $photo->image_path    = 'uploads/' . $makeImage;
            $photo->created_by    = $created;
            $photo->save();
            $img_id = $photo->id;
        }

        $product                = new Product();
        $product->title         = $request->title;
        $product->sub_title     = $request->sub_title;
        $product->category_id   = $request->category_id;
        $product->description   = $request->description;
        $product->code          = $request->code;
        $product->buying_price  = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->unit_id       = $request->unit_id;
        $product->slug          = Str::of($request->title)->slug('-');
        $product->status        = $request->status;
        $product->created_by    = $created;
        if ($request->image) {
            $product->image     = $img_id;
        }
        $product->save();
        $notification=array(
            'alert'=>'Product successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('product.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('slug', $id)->first();
        return view('pages.inventory.product.product-details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category   = Category::all();
        $unit       = Unit::all();
        return view('pages.inventory.product.product-edit', compact('product', 'category', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateData(Request $request, $id)
    {
        $created            = Auth::user()->name;
        $validatedData      = $request->validate([
            'title'         => 'required|max:120',
            'category_id'   => 'required|integer',
            'unit_id'       => 'required|integer',
            'code'          => 'required',
            'buying_price'  => 'required',
            'selling_price' => 'required',
        ],
            [
                'category_id.integer' => 'The category field is required',
                'unit_id.integer' => 'The unit field is required',
            ]);

        $product                = Product::find($id);
        $product->title         = $request->title;
        $product->sub_title     = $request->sub_title;
        $product->category_id   = $request->category_id;
        $product->description   = $request->description;
        $product->code          = $request->code;
        $product->buying_price  = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->unit_id       = $request->unit_id;
        $product->slug          = Str::of($request->title)->slug('-');
        $product->status        = $request->status;
        $product->updated_by    = $created;
        if ($request->image) {
            if ($request->image) {
                if ($product->image) {
                    $removeImg = Photo::find($product->image);
                    unlink($removeImg->image_path);
                    $removeImg->delete();
                }
                $getImage = $request->image;
                $makeImage = Str::random(20) . '.' . $getImage->getClientOriginalExtension();
                // resizing an uploaded file
                Image::make($getImage)->resize(898, 517)->save(public_path('uploads/' . $makeImage));
                $photo                = new Photo();
                $photo->image_path    = 'uploads/' . $makeImage;
                $photo->created_by    = $created;
                $photo->save();
                $img_id = $photo->id;
            }
            $product->image     = $img_id;
        }
        $product->save();
        $notification=array(
            'alert'=>'Product successfully created.',
            'alert-type'=>'success'
        );
        return redirect()->route('product.index')->with($notification);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->image) {
            $removeImg = Photo::find($product->image);
            unlink($removeImg->image_path);
            $removeImg->delete();
        }
        $product->delete();
        return response()->json("Deleted Done");
    }
}
