# MagaStock Inventaire

Application web de gestion d'inventaire développée dans le cadre d'un projet **BTS CIEL**.

## Description

MagaStock Inventaire permet de gérer des produits, d'enregistrer des entrées et sorties de stock, et d'afficher des alertes lorsque la quantité d'un produit passe sous un seuil défini.

## Technologies utilisées

- PHP natif
- SQLite (développement local)
- MySQL (prévu pour la production)
- Bootstrap 5 via CDN
- Bootstrap Icons via CDN
- JavaScript (vanilla)
- CSS

## Architecture du projet

```
magastock-inventaire/
├── assets/          # CSS, JS, images
├── config/          # Configuration base de données
├── database/        # SQLite, schéma SQL, initialisation
├── functions/       # Fonctions PHP métier
├── templates/       # Templates HTML/PHP
├── index.php        # Point d'entrée unique (routeur)
└── logout.php       # Déconnexion
```

## Installation locale

### 1. Cloner le dépôt

```bash
git clone https://github.com/BTS-ciel-st-Francois/magastock-inventaire.git
cd magastock-inventaire
```

### 2. Initialiser la base SQLite

```bash
php database/init.php
```

### 3. Lancer le serveur de développement

```bash
php -S localhost:8000
```

Ouvrir ensuite [http://localhost:8000](http://localhost:8000) dans le navigateur.

## Identifiants de test

| Utilisateur | Mot de passe |
|-------------|--------------|
| admin       | admin123     |

## Base de données

SQLite est utilisé en développement local.  
MySQL est prévu pour une version future en production (seul le fichier `config/database.php` sera à adapter).
