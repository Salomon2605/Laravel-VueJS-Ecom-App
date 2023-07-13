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
  + La solution est d'aller dans le fichier "config/database.php" et remplacer la ligne <'engine' => null,> par <'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',> 

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
- << On va profiter de Inertia installé par Breeze et l'utiliser >> 
Par exemple "Inertia::render('Dashboard');" Inertia avec son render va dans le dossier \resources\js\Pages, c'est là que se trouve tous les fichiers vue quand on est avec l'authentification breeze avec Vue Js

Notes - Explication pour mes vues
- Pour construire les nouvelles pages, je choisis d'utiliser Vue Js, j'ai commencé par essayer de comprendre commment le dashbord, l'accueil a été fait. J'ai remarqué qu'il heritait du composant layouts <AuthenticatedLayout></AuthenticatedLayout>, disons que ce layout est la base, le socle que chaque page utilise ou utilisera en spécifiant les contenus de chaque partie, par exemple il y a l'entete à 
    specifier dans le header : 
    + 
    <template #header>
        //l'entete, on specifiera le titre ou le nom de la page 
    </template>
    + Je rappelle que toutes nos pages doivent être dans le dossier Pages (\resources\js\Pages), on peut créer des sous-dossiers si on veut mais on doit rester dans ce dossier,
    et pour les rendus, pour les affichages on utilisera "return Inertia::render('Dashboard');", dans la parenthèse du render, on met le chemin à partir du dossier Pages, là on a juste "Dashboard" parce qu'il n'est pas dans un autre sous-dossier, par exemple pour rendre la page d'edit on aura render('Profile/Edit');
    + Apres pour envoyer la vue (Inertia) avec des données depuis le controller : return Inertia::render('Products/allProducts', ['products' => $products, 'users' => $users]);
    + Pour Vue Js, dans les fichiers .vue :
      - pour image par exemple src="{{ $product->image }}" devient :src="product.image"
      - par exemple {{ $product->name }} devient {{ product.name }}

Maintenant on passe à l'implémentation de notre ajout de panier concrètement : 
 - on a besoin d'un controller 
 - on a besoin d'utiliser notre librairie (darryldecode/cart) qu'on avait installé
 - on a besoin de routes
 - on a besoin de pleins de choses côté serveur

 *** On va y aller en API ***
+ Controller : "php artisan make:controller Api/CartController --api" (il va créer un controller dans un nouveau dossier Api, le --api pour qu'il crée déjà les methodes d'un api)
+ On va créer les routes dans \routes\api.php : j'ai mis des commentaires d'éclaircissement dans le api.php
+ << php artisan route:list >> pour voir nos routes apres coding du api.php
+ << php artisan route:list --name="products" >> pour voir pour products uniquement, j'ai mis "products" en apiResource dans le api.php
 - Dans l'appel du composant, le bouton Ajouter au panier, on va passer des props : 
  <AddToCart :product-id = "product.id"></AddToCart>, là on lui a passé product-id et on l'a recupéré au niveau du code du component AddToCart.vue
  - Maintenant on doit l'envoyer vers notre controller or dans notre controller on a besoin d'etre connecté 
  - A propos de l'authentification, il faut aller dans le fichier kernel.php dans (app/http) pour decommenter la ligne qui permettra à "sanctum" de pouvoir travailler avec les tokens (c'est la ligne qui comporte ceci : "\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class," ) 
- Regarder le fichier AddToCart.vue pour bien voir..
- Ensuite, on va se créer une classe qui va etre dédiée à la gestion du panier (nous sommes dans le store du CartController)
la classe est << CartRepository() >>, on y aura par exemple une fonction add($params) pour l'ajout au panier en lui passant le produit en params
- On va creer un dossier "Repositories" sous app, et y creer le CartRepository
- Etant créé manuellement, il est vide donc on y ajoute une balise <?php, son namespace et on ouvre la classe pour y mettre les fonctions et tout
- On y a créé 3 fonctions, 
nous utilisons la librairie de darryldecode, du coup on va simplement copier sur le github de la librairie en defilant en bas dans la section "Quick Usage", on adapte en modifiant les parties nécessaires

- On a fait un formatted_price dans le model Product, qui est different du price meme car il est formaté pour la vue tandis que le price n'est pas formaté et sera utiliser pour les paiements

*** API COMPOSITION ***

On va mettre les methodes reutilisables dans un autre fichier les utiliser à chaque fois qu'on en a besoin, cela nous evitera de copier les memes codes à chaque fois. Pour le faire :
 - on a créé un dossier "composables" on le nomme comme on veut; c'est lui qui contiendra les reutilisables;
 - on a créé un sous-dossier "products" pour y mettre toutes les methodes qui concernent les produits uniquement
 - dans ce dossier on a créé un fichier .js (ex: index.js) qui va contenir les codes meme des methodes
 - Dans le fichier .js, on créé une fonction : 
    export default function nomDeLaFonction()
    {...} qui contient toutes les methodes concernant les produits
 - Confert \resources\js\composables\products\index.js pour plus de details et de comprehension
 - On a voulu l'utiliser au niveau de l'ajout au panier, AddToCart.vue pour voir comment on l'a utilisé
 - Dans notre cas on a mis la methode d'ajout au panier dans le fichier js et on l'a appelé pour l'utiliser dans le AddToCart.vue.

 (...)

On doit maintenant faire en sorte que le chiffre au niveau du panier s'actualise lorqu'on fait Ajouter au Panier
- On aura besoin de creer de petits evenements entre composants, donc on utilisera << tiny-emitter >> qui nous permettra de faire ça vraiment simplement (https://www.npmjs.com/package/tiny-emitter)
 + npm install tiny-emitter --save
 + Voilà comment il fonctionne : 
   * on l'importe : import Emitter from 'tiny-emitter';
   * on crée une nouvelle instance pour l'utiliser : const nomEmitter = new Emitter();
   * On l'emet avec la syntaxe : nomEmitter.emit('unNomDappel', 'arg1', 'arg2', ...);
   * On l'écoute et on travaille dedans avec : 
      emitter.on('unNomDappel', (param) => {
        cartCount.value = param; (on a mis count en param parce que la reponse qui vient dans le emit, vient sous la forme 'param' => ...., on utilise ce qui vient depuis là bas) 
      });
 + Simplement comme ci-dessus, ça fonctionne quand tout est sur la meme vue, dans mon cas j'ai des components distincts, l'emission de l'emitter se fait au niveau du component AddToCart pour l'ajout au panier et la mise à jour automatique du nombre au niveau du panier se fait dans le component NavBarCart :
   * si sur chaque vue, on fait le import et la new instance pour << emitter >>, cela ne fonctionnera pas, rappelons que c'est la meme instance qui est emise au niveau du AddToCart, qui sera ecouté au niveau du NavBarCart, si on fait new sur les deux vues, on aura rien
   * pour le faire donc, etant donné notre emitter sera exploité dans deux components, on va créer une constante réutilisable à part qui sera importé dans le AddToCart et le NavBarCart, je suis dons allé dans mon dossier où je mets les fichiers contenant les methodes réutilisables, et j'ai créé un nouveau fichier .js (j'ai donné le nom eventBus.js) dans lequel j'ai fait l'import de tiny-emitter et j'ai créé la new instance que les deux components vont exploiter, l'un s'occupe de l'emission et l'autre s'occupe de l'ecoute de l'evenement.
     * dans mon eventBus.js, pour creer les instances que plusieurs vues exploiteront : (des exemples)
        - export const nomEmitter = new Emitter();
        - export const cartEmitter = new Emitter();
        - export const userEmitter = new Emitter();
     bien sur apres avoir importé Emitter avec "import Emitter from 'tiny-emitter';" 
     * pour importer les emitters là où ils seront exploités, on fait par exemple :
        - import { cartEmitter } from '../composables/products/eventBus';
     * après l'avoir importé, on travaille dessus seulement comme fait dans les fichiers AdddToCart.vue et NavBarCart.vue 

Bon à savoir : meme si on veut utiliser un << emitter >> sur une seule vue, c'est plus propre de le creer ailleurs et de l'importer 

- Il faut etre connecté pour ajouter des produits au panier
- on va utiliser le systeme de notification toast avec la librairie Vue Toaster (https://github.com/MeForma/vue-toaster) pour les notifications
  * npm install @meforma/vue-toaster
  * Après on l'a importé et utilisé localement en suivant la documentation dans le README.md de la librairie 
  