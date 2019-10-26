<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Product;
use App\Category;

class CatalogsController extends Controller
{
    public function index(Request $request)
    {

    	$q = $request->get('q');
    	if ($request->has('cat')) {
    		$cat = $request->get('cat');
    		$category = Category::findOrFail($cat);
    		$products = Product::whereIn('id', $category->related_products_id)
    			->where('name', 'LIKE', '%' . $q . '%');
    	} else {
    		$products = Product::where('name', 'LIKE', '%' . $q . '%');
    	}

    	if ($request->has('sort')) {
    		$sort = $request->get('sort');
    		$order = $request->has('order') ? $request->get('order') : 'asc';
    		$field = in_array($sort, ['price', 'name']) ? $request->get('sort') : 'price';
    		$products = $products->orderBy($field, $order);
    	}

    	$products = $products->paginate(4);

    	return view('catalogs.index', compact('products', 'cat', 'category', 'q', 'sort', 'order'));
    }
}
