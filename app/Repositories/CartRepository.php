<?php 

namespace App\Repositories;

use App\Models\Product;

class CartRepository 
{
    //la fonction d'ajout au panier
    public function add(Product $product)
    {
        // add the product to cart
        \Cart::session(auth()->user()->id)->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price, //le vrai prix est envoyé au panier, pas le prix formaté
            'quantity' => 1, // 1 d'abord, ça va s'incrémenter après
            'attributes' => array(),
            'associatedModel' => $product
        ));

        return $this->count(); //le count envoie le nombre de produits ajoutés
    }

    //la fonction pour afficher le contenu globale du panier
    public function content()
    {
        //on appelle le panier de la session et on lui applique la fonction getContent() de la librairie
        return \Cart::session(auth()->user()->id)
                    ->getContent();
    }

    //pour avoir la quantité d'éléments dans notre panier
    public function count()
    {
        //return $this->content()->count(); //count va sortir le nombre de produits mais pas la quantité totale de produits
        //pour avoir la quantité totale de produits
        return $this->content()->sum('quantity');
    }
}