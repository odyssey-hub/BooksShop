<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MainController extends Controller
{
    public function index(ProductsFilterRequest $request)
    {
        $skusQuery = Sku::with(['product', 'product.category']);
        if ($request->filled('price_from')) {
            $skusQuery->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $skusQuery->where('price', '<=', $request->price_to);
        }

        if ($request->filled('year_from')){
            $skusQuery->whereHas('product',  function (Builder $query) use ($request) {
                $query->where('year', '>=', $request->year_from);
            });
        }

        if ($request->filled('author')) {
            $skusQuery->whereHas('product',  function (Builder $query) use ($request) {
                $query->where('author', 'LIKE', "%".$request->author."%");
            });
        }

        if ($request->filled('book_name')) {
            $skusQuery->whereHas('product',  function (Builder $query) use ($request) {
                $query->where('name', 'LIKE', "%".$request->book_name."%");
            });
        }

        if ($request->filled('year_to')){
            $skusQuery->whereHas('product',  function (Builder $query) use ($request) {
                $query->where('year', '<=', $request->year_to);
            });
        }
        if ($request->filled('filterGenre')){
            if ($request->filterGenre != "Все") {
                $skusQuery->whereHas('product',  function (Builder $query) use ($request) {
                    $query->where('genres', '=', $request->filterGenre);
                });
            }
        }

        foreach (['hit', 'new', 'recommend'] as $field) {
            if ($request->has($field)) {
                $skusQuery->whereHas('product', function ($query) use ($field) {
                    $query->$field();
                });
            }
        }

        if ($request->filled('sortField')){
            $field = $request->sortField;
            if ($request->sortOrder =="asc"){
                $skusQuery->orderBy($field);
            } else {
                $skusQuery->orderByDesc($field);
            }
        }

        $skus = $skusQuery->paginate(6)->withPath("?".$request->getQueryString());

        return view('index', compact('skus'));
    }



    public function categories()
    {
        return view('categories');
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->first();
        return view('category', compact('category'));
    }

    public function sku($categoryCode, $productCode, Sku $skus)
    {
        if ($skus->product->code != $productCode) {
            abort(404, 'Product not found');
        }

        if ($skus->product->category->code != $categoryCode) {
            abort(404, 'Category not found');
        }

        return view('product', compact('skus'));
    }

    public function subscribe(SubscriptionRequest $request, Sku $skus)
    {
        Subscription::create([
            'email' => $request->email,
            'sku_id' => $skus->id,
        ]);

        return redirect()->back()->with('success', __('product.we_will_update'));
    }

    public function changeLocale($locale)
    {
        $availableLocales = ['ru', 'en'];
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

    public function changeCurrency($currencyCode)
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency' => $currency->code]);
        return redirect()->back();
    }
}
