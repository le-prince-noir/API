# API Documention

# Endpoints

## FILMS

```
GET /films?token=
Liste de tout les films
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
PUT /films?token=
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
GET /user/@pseudo/pref?token=
Liste les films que l'utilisateur like
```

```
GET /user/@pseudo/view?token=
Liste les films que l'utilisateur a déjà vu
```

```
GET /user/@pseudo/love?token=
Liste les films que l'utilisateur aimerait voir
```

```
GET /users?token=
Liste tous les utilisateurs
```

```
GET /users/@id?token=
Affiche 1 utilisateur
```

```
POST /users/?token=
Création d'un utilisateur : champs :
-> pseudo
-> mdp
-> email
-> niveau
```

```
DELETE /users?token=
Suppression d'un utilisateur
```

```
PUT /users?token=
Modification d'un utilisateur champs :
-> pseudo
-> mdp
-> email
```