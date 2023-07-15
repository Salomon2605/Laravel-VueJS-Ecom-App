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

    //pour augmenter la quantité pour un produit
    public function increase($id)
    {
        \Cart::session(auth()->user()->id) //on récupère le panier de celui qui est authentifié
               ->update($id, [  //dans la librairie on a une méthode update qu'on utilise pour les mises à jour et qui prend en paramètres l'id du produit et les modifications à apporter
                    'quantity' => +1
               ]);
    }

    //pour diminuer la quantité pour un produit
    public function decrease($id)
    {
        //on recupere le produit concerné avec la methode get de la librairie et l'id du produit
        $item = \Cart::session(auth()->user()->id)->get($id);

        if ($item->quantity === 1) //on verifie si la quantité est egal 1 pour carrement le supprimer 
        {
            $this->removeProduct($id);
            
            return;

        } else {
            \Cart::session(auth()->user()->id) //on récupère le panier de celui qui est authentifié
               ->update($id, [  //dans la librairie on a une méthode update qu'on utilise pour les mises à jour et qui prend en paramètres l'id du produit et les modifications à apporter
                    'quantity' => -1
            ]);
        }
    }

    public function removeProduct($id)
    {
        //pour l'enlever du panier, on utilisera la methode remove() de la librairie en lui passant l'id du produit à enlevé du panier
        \Cart::session(auth()->user()->id)->remove($id);
    }

    public function total()
    {
        return \Cart::session(auth()->user()->id)->getTotal();

        //pour avoir le prix total, on a une methode getTotal() dans la librairie qui permet d'avoir le prix total du panier 
    }

    //pour recuperer tous les elements du panier en Json pour les infos complementaires qu'on veut joindre au paiement
    public function getJsonOrderItems()
    {
        return $this->content()
             ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ];
             })
             ->toJson();
    }
}