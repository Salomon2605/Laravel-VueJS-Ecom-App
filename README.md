Notes : 
Bon à savoir : 
    L'architecture des fichiers dans un projet purement Vue.js est différente de celle d'un projet Vue.js + Laravel ensemble.

Pour démarrer, je fais :
    - php artisan serve
    - npm install et npm run dev
        
    *** API Composition ***
- Quand on a cette erreur : 
    "Illuminate\Database\QueryException 
    SQLSTATE[42000]: Syntax error or access violation: 1071 La clé est trop longue. Longueur maximale: 1000 (Connection: mysql, SQL: alter table `users` add unique `users_email_unique`(`email`))"
  La solution est d'aller dans le fichier "config/database.php" et remplacer la ligne <'engine' => null,> par <'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',> 

- Pour installer le système d'authentification :
    + composer require laravel/breeze 
    + php artisan breeze:install 
       Avec breeze lors de l'installation, on choisit d'utiliser vue js, blade ou react js ou autres avec Laravel pour notre projet
       J'ai choisit que le système d'authentification breeze soit fait avec Vue JS
    + npm install
    + npm run dev et c'est demarré; 
- Ensuite, on va prendre une librairie laravel qu'on va utiliser pour le panier : laravel shopping cart : de la façon suivante
    + composer require "darryldecode/cart"
- On a créé un composant Vue JS dans un dossier "components" pour les boutons Ajouter au panier 
    Le component est AddToCart.vue
    Pour l'utiliser, il faut simplement l'importer dans les balises script de la vue : 
       import AddToCart from '@/components/AddToCart.vue';
       après l'appeler là où on veut le voir avec des balises portant son nom : <AddToCart></AddToCart> (AddToCart dans notre cas actuel)

    --- Je reprends ---
Par exemple "Inertia::render('Dashboard');" Inertia avec son render va dans le dossier \resources\js\Pages, c'est là que se trouve tous les fichiers vue quand on est avec l'authentification breeze avec Vue Js

Notes - Explication 
    + Pour construire les nouvelles pages, je choisis d'utiliser Vue Js, j'ai commencé par essayer de comprendre commment le dashbord, l'accueil a été fait. J'ai remarqué qu'il heritait du composant layouts <AuthenticatedLayout></AuthenticatedLayout>, disons que ce layout est la base, le socle que chaque page utilise ou utilisera en spécifiant les contenus de chaque partie, par exemple il y a l'entete à 
    specifier dans le header : 
    <template #header>
        //l'entete, on specifiera le titre ou le nom de la page 
    </template>
    + Je rappelle que toutes nos pages doivent être dans le dossier Pages (\resources\js\Pages), on peut créer des sous-dossiers si on veut mais on doit rester dans ce dossier,
    et pour les rendus, pour les affichages on utilisera "return Inertia::render('Dashboard');", dans la parenthèse du render, on met le chemin à partir du dossier Pages, là on a juste "Dashboard" parce qu'il n'est pas dans un autre sous-dossier, par exemple pour rendre la page d'edit on aura render('Profile/Edit');
    + Apres pour envoyer la vue (Inertia) avec des données depuis le controller : return Inertia::render('Products/allProducts', ['products' => $products, 'users' => $users]);
    + Pour Vue Js, dans les fichiers .vue :
      - pour image par exemple src="{{ $product->image }}" devient :src="product.image"
      - par exemple {{ $product->name }} devient {{ product.name }}