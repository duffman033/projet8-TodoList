# Bienvenue sur ToDoList !

***

| Projet 8 : Améliorer un projet existant. |
|------------------------------------------|

***

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/bd26cc5ae58c4d318a64d5bae21b856d)](https://www.codacy.com/gh/duffman033/projet8-TodoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=duffman033/projet8-TodoList&amp;utm_campaign=Badge_Grade)

## Prêt à démarrer ?

Pour débuter, il te suffit de cloner le projet sur ton ordinateur avec la commande :

```text
git clone https://github.com/duffman033/projet8-TodoList.git
```

Ensuite, il te faut installer les dépendances backend nécessaires pour faire tourner notre application. Tu peux le faire
simplement en exécutant la commande "composer install" depuis le répertoire du projet cloné :

```text
composer install
```

N'oublie pas de configurer ta connexion à la base de données dans le fichier .env.

C'est le moment de créer ta base de données ! Tu peux le faire en tapant la commande suivante :

```text
php bin/console doctrine:database:create
```

Maintenant, construisons le schéma de données dans ta base de données avec cette commande :

```text
php bin/console doctrine:schema:create
```

Et enfin, migrons les données dans ta base de données avec la commande suivante :

```text
php bin/console doctrine:fixtures:load
```

### Lance ton Projet !

* Pour lancer le serveur, tape simplement `symfony server:start`.

### Super ! Tu peux désormais accéder au projet à l'adresse : http://127.0.0.1:8000

## Prise en Main de la Sécurité

Il est crucial pour nous que tu prennes le temps de bien comprendre notre système de sécurité. Pour cela, nous
t'invitons chaleureusement à consulter nos [guidelines dédiées à la sécurité](docs/security.md). Tu y trouveras toutes
les informations nécessaires concernant la gestion de l'authentification et des règles de sécurité. N'hésite pas à t'y
référer régulièrement, ta contribution sera d'autant plus efficace !

## Tu veux contribuer ?

Génial, nous adorons recevoir de l'aide de la communauté ! Avant de te lancer, n'oublie pas de lire
nos [consignes de contribution](docs/contributing.md).
Tu y trouveras des instructions pour ouvrir des problèmes, les normes de codage, et des notes sur le développement.
Alors, prêt à améliorer notre ToDoList ?
