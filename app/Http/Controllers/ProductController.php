<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view("product.index", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("product.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();

        $input = $request->all();

        $product->fill($input);

        $product->save();

        return to_route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function buy(Product $product)
    {
        MercadoPagoConfig::setAccessToken(env("MERCADO_PAGO_ACCESS_TOKEN"));

        $client = new PreferenceClient();
        $preference = $client->create([
            "back_urls" => array(
                "success" => "https://d839-2804-30c-f7f-3c00-5143-935d-e98-a0c6.ngrok-free.app/product",
                "failure" => "https://d839-2804-30c-f7f-3c00-5143-935d-e98-a0c6.ngrok-free.app/product",
                "pending" => "https://d839-2804-30c-f7f-3c00-5143-935d-e98-a0c6.ngrok-free.app/product"
            ),
            "items" => array(
                array(
                    "id" => "$product->id",
                    "title" => "$product->name",
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => $product->price
                )
            ),
            "auto_return" => "all",
        ]);

        $response = $preference->getResponse();

        $content = $response->getContent();

        return redirect($content['init_point']);
    }
}
