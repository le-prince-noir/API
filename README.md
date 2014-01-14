# API Documention

# Endpoints

## FILMS

```
GET /v1/films
Liste de tout les films
```

```
POST /v1/films
Création film : champs :
-> name
-> desc_film
-> auteur
-> date_diffusion
```

```
PUT /v1/films
Modification film : champs :
-> name
-> desc_film
-> auteur
-> date_diffusion
-> id
```

```
DELETE /v1/films/@id
Suppression film : champ :
-> id
```

```
GET /v1/films/cat/@cat
Liste les films par la categorie
```

## USERS

```
GET /v1/user/@pseudo/pref
Liste les films que l'utilisateur like
```

```
GET /v1/user/@pseudo/view
Liste les films que l'utilisateur a déjà vu
```

```
GET /v1/user/@pseudo/love
Liste les films que l'utilisateur aimerait voir
```