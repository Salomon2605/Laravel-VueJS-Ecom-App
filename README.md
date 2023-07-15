# Laravel-VueJS-Ecom-App

Application e-commerce réalisé avec Vue JS 3 et Laravel 10.

## Fonctionnalités

- Affichage aléatoire d'une liste de produits depuis la base de données.
- Ajout de produits au panier pour les utilisateurs connectés.
- Consultation du panier et passage au paiement.
- Intégration de Stripe pour les paiements sécurisés.
- Gestion des utilisateurs : inscription, connexion, modification de profil et suppression de compte.
- Navbar avec onglets pour accéder au tableau de bord et à la liste des produits.
- Icône du panier affichant le nombre de produits ajoutés.

## Technologies Utilisées

- Vue.js 3 : Framework JavaScript pour la construction de l'interface utilisateur.
- Laravel 10 : Framework PHP pour le développement backend.
- Breeze : Kit de démarrage Laravel pour l'authentification et la gestion des utilisateurs.
- Darryldecode/Cart : Librairie pour la gestion du panier d'achat.
- API Composition : Architecture pour la composition des API backend.
- Tiny-Emitter : Bibliothèque pour la gestion des événements.
- Vue Toaster : Composant Vue pour les notifications.
- Stripe : Plateforme de paiement pour les transactions sécurisées.

## Installation

1. Clonez le dépôt GitHub.

git clone https://github.com/Salomon2605/Laravel-VueJS-Ecom-App.git

2. Installez les dépendances du frontend.
    cd Laravel-VueJS-Ecom-App
    npm install
    composer install

3. Configurez les fichiers d'environnement
    Dupliquez le fichier .env.example dans le dossier backend et renommez-le en .env. 
    Configurez les variables d'environnement telles que la base de données, les clés d'API, etc.

4. Exécutez les migrations et générez une clé d'application.
    php artisan migrate
    php artisan key:generate

5. Exécutez les seeders pour remplir la base de données avec des données de test.
    php artisan db:seed

6. Démarrez le serveur de développement.
    php artisan serve

7. Démarrez le front
    npm install
    npm run dev

Accédez à l'application dans votre navigateur à l'adresse http://127.0.0.1:8000/.