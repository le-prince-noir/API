# API Documention

## FILMS

```
GET /films?token=
Liste de tout les films
```

```
GET /films/@id?token=
Affiche un film
```

```
POST /films?token=
Création film : champs :
-> name
-> desc_film
-> auteur
-> date_diffusion
```

```
PUT /films/@id?token=
Modification film : champs :
-> name
-> desc_film
-> auteur
-> date_diffusion
-> id
```

```
DELETE /films/@id?token=
Suppression film : champ :
-> id
```

```
GET /films/cat/@cat?token=
Liste les films par la categorie
```

## USERS

### En fonction du niveau de l'utilisateur : super-admin | admin | user // les infos affichés sont diff

```
GET /user/self/liked?token=
Liste les films que l'utilisateur like
```

```
GET /user/self/watched?token=
Liste les films que l'utilisateur a déjà vu
```

```
GET /user/self/wanted?token=
Liste les films que l'utilisateur aimerait voir
```

```
GET /users?token=
Liste tous les utilisateurs
```

```
GET /users/@id?token=
Affiche un utilisateur
```

```
POST /users?token=
Création d'un utilisateur : champs :
-> pseudo
-> mdp
-> email
-> niveau
```

```
DELETE /users/@id?token=
Suppression d'un utilisateur
```

```
PUT /users/@id?token=
Modification d'un utilisateur champs :
-> pseudo
-> mdp
-> email
```