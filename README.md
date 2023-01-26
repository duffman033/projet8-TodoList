# ToDoList

***
| Projet 8 : Améliorer un projet existant. |
|------------------------------------------|
***

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/bd26cc5ae58c4d318a64d5bae21b856d)](https://www.codacy.com/gh/duffman033/projet8-TodoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=duffman033/projet8-TodoList&amp;utm_campaign=Badge_Grade)

## Installation du projet

Cloner le projet sur votre machine avec la commande :

```text
git clone https://github.com/duffman033/projet8-TodoList.git
```

Ensuite, effectuez la commande "composer install" depuis le répertoire du projet cloné, afin d'installer les dépendances back nécessaires :

```text
composer install
```

Configurer la connexction à votre base de données dans le fichier .env

Maintenant, effectuez la commande "bin/console doctrine:database:create" pour créer votre base de données :

```text
php bin/console doctrine:database:create
```

Tapez la commande "php bin/console doctrine:schema:create" pour créer le shéma de données dans votre base de données :

```text
php bin/console doctrine:schema:create
```

Maintenant avec la commande "php bin/console doctrine:fixtures:load" vous allez migrer les données dans votre base de données:

```text
php bin/console doctrine:fixtures:load
```


### Lancer le projet

*   Pour lancer le serveur, effectuez un `symfony server:start`.

### Bravo, le projet est désormais accessible à l'adresse : http://127.0.0.1:8000

