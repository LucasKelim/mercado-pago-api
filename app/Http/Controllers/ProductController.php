<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Client\Payment\PaymentClient;
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
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $product->fill($input);

        $product->update();

        return to_route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('product.index');
    }

    public function buy(Product $product)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        $client = new PreferenceClient();
        $preference = $client->create([
            "back_urls" => array(
                "success" => "https://282d-2804-30c-f7f-3c00-dd6f-5449-88e5-4e8a.ngrok-free.app/products",
                "failure" => "https://282d-2804-30c-f7f-3c00-dd6f-5449-88e5-4e8a.ngrok-free.app/products",
                "pending" => "https://282d-2804-30c-f7f-3c00-dd6f-5449-88e5-4e8a.ngrok-free.app/products"
            ),
            "items" => array(
                array(
                    "id" => $product->id,
                    "title" => $product->name,
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => 9
                )
            ),
            "payer" => [
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
            ],
            "auto_return" => "all",
            "external_reference" => $product->id,
            "statement_descriptor" => "Test Store",
            "metadata" => [
                "user_id" => Auth::user()->id,
            ]
        ]);

        $response = $preference->getResponse();

        $content = $response->getContent();

        return redirect($content['init_point']);
    }

    public function payments() {}

    public function webhook()
    {
        return response()->json(['status' => 'ok']);
    }
}
