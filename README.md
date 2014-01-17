# API Documention

## FILMS

```
GET /v1/films?token=
Liste de tout les films
```

```
GET /v1/films/@id?token=
Affiche un film
```

```
POST /v1/films?token=
Création film : champs :
-> name
-> desc_film
-> auteur
-> date_diffusion
```

```
PUT /v1/films/@id?token=
Modification film : champs :
-> name
-> desc_film
-> auteur
-> date_diffusion
-> id
```

```
DELETE /v1/films/@id?token=
Suppression film : champ :
-> id
```

```
GET /v1/films/cat/@cat?token=
Liste les films par la categorie
```

## USERS

### En fonction du niveau de l'utilisateur : super-admin | admin | user // les infos affichés sont diff

```
GET /v1/user/self/liked?token=
Liste les films que l'utilisateur like
```

```
GET /v1/user/self/watched?token=
Liste les films que l'utilisateur a déjà vu
```

```
GET /v1/user/self/wanted?token=
Liste les films que l'utilisateur aimerait voir
```

```
GET /v1/users?token=
Liste tous les utilisateurs
```

```
GET /v1/users/@id?token=
Affiche un utilisateur
```

```
POST /v1/users
Pas de token pour la création d'un nouvel utilisateur (car il ne le connait pas encore :) )
Création d'un utilisateur : champs :
-> pseudo
-> mdp
-> email
-> niveau
```

```
DELETE /v1/users/@id?token=
Suppression d'un utilisateur
```

```
PUT /v1/users/@id?token=
Modification d'un utilisateur champs :
-> pseudo
-> mdp
-> email
```