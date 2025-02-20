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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            "payer" => array(
                "name" => "Test",
                "surname" => "User",
                "email" => "your_test_email@example.com",
                "phone" => array(
                    "area_code" => "11",
                    "number" => "4444-4444"
                ),
                "identification" => array(
                    "type" => "CPF",
                    "number" => "19119119100"
                ),
                "address" => array(
                    "zip_code" => "06233200",
                    "street_name" => "Street",
                    "street_number" => "123"
                )
            ),
            "auto_return" => "all",
            "payment_methods" => array(
                "default_payment_method_id" => "master",
                "excluded_payment_types" => array(
                    array(
                        "id" => "visa"
                    )
                ),
                "excluded_payment_methods" => array(
                    array(
                        "id" => ""
                    )
                ),
                "installments" => 5,
                "default_installments" => 1
            ),
            "shipments" >= array(
                "mode" => "custom",
                "local_pickup" => false,
                "default_shipping_method" => null,
                "free_methods" => array(
                    array(
                        "id" => 1
                    )
                ),
                "cost" => 10,
                "free_shipping" => false,
                "dimensions" => "10x10x20,500",
                "receiver_address" => array(
                    "zip_code" => "06000000",
                    "street_number" => "123",
                    "street_name" => "Street",
                    "floor" => "12",
                    "apartment" => "120A",
                    "city_name" => "Rio de Janeiro",
                    "state_name" => "Rio de Janeiro",
                    "country_name" => "Brasil"
                )
            ),
            "statement_descriptor" => "Test Store",
        ]);

        $response = $preference->getResponse();

        $content = $response->getContent();

        return redirect($content['init_point']);
    }
}
