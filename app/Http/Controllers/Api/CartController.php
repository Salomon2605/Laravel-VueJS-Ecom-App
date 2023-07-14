<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartContent = (new CartRepository())->content(); //Dans le repository, gerant tout ce dont on a besoin pour le panier, on a a créé la methode content() pour nous prendre le contenu du panier de la personne connecté 
        
        $cartCount = (new CartRepository())->count();

        return response()->json([
            'cartContent' => $cartContent, 
            'cartCount' => $cartCount 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::where('id', $request->productId)->first();
        $count = (new CartRepository())->add($product); //on a envoyé le count par la fonction add() 

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        (new CartRepository())->removeProduct($id);
    }

    public function count()
    {
        $count = (new CartRepository())->count();

        return response()->json([
            'count' => $count
        ]);
    }

    public function increase($id)
    {
        (new CartRepository())->increase($id);
    }

    public function decrease($id)
    {
        (new CartRepository())->decrease($id);
    }
}
