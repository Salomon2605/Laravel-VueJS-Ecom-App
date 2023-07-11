Notes : 
        API Composition
- Quand on a cette erreur : 
    "Illuminate\Database\QueryException 
    SQLSTATE[42000]: Syntax error or access violation: 1071 La clé est trop longue. Longueur maximale: 1000 (Connection: mysql, SQL: alter table `users` add unique `users_email_unique`(`email`))"
  La solution est d'aller dans le fichier "config/database.php" et remplacer la ligne <'engine' => null,> par <'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',> 

- Pour installer le système d'authentification :
    + composer require laravel/breeze 
    + php artisan breeze:install 
       Avec breeze lors de l'installation, on choisit d'utiliser vue js, blade ou react js ou autres avec Laravel pour notre projet
       J'ai choisit que le système d'authentification breeze soit fait avec blade
    + npm install
    + npm run dev et c'est demarré; faire un npm run watch quand on est avec blade 
- Après l'installation de breeze, avec blade, on passe à l'installation de vue Js 3 dans notre projet
    + npm install vue@next vue-loader
- Ensuite, on va prendre une librairie laravel qu'on va utiliser pour le panier : laravel shopping cart : de la façon suivante
    + composer require "darryldecode/cart"
- On a créé un composant Vue JS dans un dossier "components" pour les boutons Ajouter au panier 
    Le component est AddToCart.vue, on l'enregistre auprès de vue (app.component....) et apres on l'a appelé comme suit: <add-to-cart></add-to-cart> 