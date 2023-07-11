<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('total_quantity', 'total_price'); //parce qu'on a ajouté ces deux champs dans la table pivot entre order et produit
    }

    //On veut formater le prix avec un getter
    public function price(): Attribute //bien faire attention à importer un attribut provenant des chemins "Eloquent"
    {
        return Attribute::make(
            get: fn($value) => str_replace('.', ',', $value/100) . ' €'
        );
    }
}
