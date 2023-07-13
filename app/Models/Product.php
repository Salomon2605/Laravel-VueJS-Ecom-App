<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $appends = ['formatted_price'];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('total_quantity', 'total_price'); //parce qu'on a ajouté ces deux champs dans la table pivot entre order et produit
    }

    //On veut formater le prix avec un getter
    // public function price(): Attribute //bien faire attention à importer un attribut provenant des chemins "Eloquent"
    // {
    //     return Attribute::make(
    //         get: fn($value) => str_replace('.', ',', $value/100) . ' €'
    //     );
    // }

    
    //pour appeller le resultat de getFormattedPriceAttribute(), il faut appeler "formatted_price", laravel le reconnait directement
    //Pour le reconnaitre, Laravel utilise le mot entre le get et le Attribute dans le nom de la fonction, 
    //donc "FormattedPrice" d'où "formatted_price" et faut le mettre dans le appends au debut 

    public function getFormattedPriceAttribute() 
    {
        return str_replace('.', ',', $this->price /100) . ' €';
    }
}
