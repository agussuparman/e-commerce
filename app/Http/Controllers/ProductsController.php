<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Product;
use Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $products = Product::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('model', 'LIKE', '%' . $q . '%')
            ->orderBy('name')->paginate(10);
        return view('products.index', compact('products', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:products',
            'model' => 'required|max:255',
            'photo' => 'mimes:jpeg,jpg,png|max:10240',
            'price' => 'required|numeric|min:1000',
            'weight' => 'required|numeric|min:1',
        ]);
        $data = $request->only('name', 'model', 'price', 'weight');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->savePhoto($request->file('photo'));
        }

        $product = Product::create($data);
        $product->categories()->sync($request->get('category_lists'));

        Session::flash('flash_notification', [
            'level' => 'success',
            'message' => $product->name . ' saved.'
        ]);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
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
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'model' => 'required|max:255',
            'photo' => 'mimes:jpeg,jpg,png|max:10240',
            'price' => 'required|numeric|min:1000',
            'weight' => 'required|numeric|min:1',
        ]);
        $data = $request->only('name', 'model', 'price', 'weight');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->savePhoto($request->file('photo'));
            if ($product->photo !== '') $this->deletePhoto($product->photo);
        }

        $product->update($data);
        if (count($request->get('category_lists')) > 0) {
            $product->categories()->sync($request->get('category_lists'));
        } else {
            $product->categories()->detach();
        }

        Session::flash('flash_notification', [
            'level' => 'success',
            'message' => $product->name . 'updated.'
        ]);
        return redirect()->route('products.index');
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
        if ($product->photo !== '') $this->deletePhoto($product->photo);
        $product->delete();
        Session::flash('flash_notification', [
            'level' => 'success',
            'message' => 'Product deleted.'
        ]);
        return redirect()->route('products.index');
    }

    protected function savePhoto(UploadedFile $photo)
    {
        $fileName = str_random(40) . '.' . $photo->guessClientExtension();
        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
        $photo->move($destinationPath, $fileName);
        return $fileName;
    }

    protected function deletePhoto($fileName)
    {
        $path = public_path() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $fileName;
        return File::delete($path);
    }
}
