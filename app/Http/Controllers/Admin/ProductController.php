<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('auth.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $properties = Property::get();
        app('debugbar')->info($properties);
        return view('auth.products.form', compact('categories', 'properties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $params = $request->all();

        unset($params['image']);
        if ($request->has('image')) {
            $params['image'] = $request->file('image')->store('products');
        }

        Product::create($params);
        app('debugbar')->info($params);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('auth.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::get();
        $properties = Property::get();
        return view('auth.products.form', compact('product', 'categories', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($product->image);
            $params['image'] = $request->file('image')->store('products');
        }

        foreach (['new', 'hit', 'recommend'] as $fieldName) {
            if (!isset($params[$fieldName])) {
                $params[$fieldName] = 0;
            }
        }

        //$product->properties()->sync($request->property_id);

        $product2 = Product::Find($product->id);
        $product2 = $product;
        $product2->save();
        return redirect()->route('products.index');
    }


//    public function getBestPlaces(Request $request){//получение лучших мест ловли
//        //входные данные
//        $fish = $request->fish;//вид рыбы
//        $date = $request->date;//дата
//        $cX = $request->coorX; //координаты ограничивающей области
//        $cY = $request->coorY;
//        $radius = $request->R; //радиус ограничивающей области
//        //выходные данные
//        $results = DB::table('records')->get(); // записи из журналов
//        $results = $results->filter(function ($value, $key) { //отбор записей
//            if($value->fish == $fish && $value->date >= $date //отбор по выбранному виду и дате
//                && inRadius($value->place,$cX,$cY,$radius)) { //отбор мест по радиусу круга
//                return $value;
//            }
//        });
//        $results = $collection->sortBy('catchNum');//сортировка по количеству уловов
//        return view('auth.places.index', compact('results')); //вывод результатов;
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
