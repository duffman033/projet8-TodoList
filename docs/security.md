# Configuration de Sécurité Simplifiée

## Hashage des mots de passe

Les mots de passe sont encodés automatiquement grâce à Symfony qui choisit l'encodeur de mots de passe le plus fort
disponible. Si vous souhaitez utiliser un encodeur spécifique, spécifiez-le dans la configuration `password_hashers`.

## Les providers

Le fournisseur de données utilise `App\Entity\User` pour récupérer les informations utilisateur, avec `username` comme
identifiant. Si vous voulez utiliser un autre champ, spécifiez `property: votre_champ`.

## Le Firewall

Nous avons deux pare-feux, `dev` et `main`. `Dev` exclut certaines routes pour le débogage et le test. `Main` spécifie
le fournisseur de données, la méthode d'authentification et la route de déconnexion.

## Contrôle d'Accès

Nous avons trois règles de contrôle d'accès pour réglementer l'accès aux différentes parties de l'application en
fonction des rôles des utilisateurs.

## Authentification

`Symfony\Component\Security\Http\Authentication` gère l'authentification HTTP. Après une authentification réussie, un
token est créé et stocké dans la session utilisateur.

## Stockage des utilisateurs

Les utilisateurs sont stockés dans une table MySQL `user`. Pour modifier cette structure,
utilisez `php bin/console make:entity nom_de_l’entité`. N'oubliez pas de générer une nouvelle migration et de mettre à
jour la base de données avec `php bin/console make:migration` et `php bin/console doctrine:migrations:migrate`.
Sauvegardez vos données avant toute modification.

[Voir le document Word ici](https://docs.google.com/document/d/1KGQno1c5tH5XCoPMbDRj8Q3cX3qev-Ez/edit)