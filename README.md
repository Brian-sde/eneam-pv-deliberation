# ENEAM - Gestion et Recherche des Procès-Verbaux (PV) de Délibération

Application web développée sous **Laravel** pour la numérisation, l'archivage sécurisé, l'intégrité et la recherche multicritère des PV de délibération de l'**École Nationale d'Économie Appliquée et de Management (ENEAM - UAC)**.

---

## 🎯 Objectifs du Projet

- **Numérisation et Archivage** : Centraliser les PV de délibération papier en version numérique (PDF/Images) avec garantie d'intégrité par empreinte cryptographique (SHA-256).
- **Recherche Multicritère Instantanée** : Retrouver en quelques secondes un PV par promotion (année académique, filière, niveau, semestre, session) ou par étudiant (nom, prénom, matricule).
- **Fiche Étudiant & Parcours** : Visualiser l'historique complet d'un étudiant à travers toutes ses délibérations (admis, ajourné, compensation, rattrapage).
- **Sécurité & Traçabilité** : Journal des accès et modifications (Audit log) et filigrane dynamique sur les visualisations de documents sensibles.
- **Tableau de Bord Décisionnel** : Indicateurs de réussite par filière et détection des PV manquants (matrice de complétude).

Consultez le document complet dans [`docs/CAHIER_DES_CHARGES.md`](docs/CAHIER_DES_CHARGES.md).

---

## 👥 Rôles Utilisateurs

1. **Administrateur** : Configuration générale, gestion des comptes et rôles, consultation des logs d'audit.
2. **Agent de Scolarité / Examens** : Numérisation des scans, saisie ou import Excel des listes d'étudiants et décisions.
3. **Chef de Département / Direction** : Contrôle, validation officielle des délibérations, statistiques comparatives.
4. **Enseignants** : Consultation en lecture seule des délibérations de leurs filières.

---

## 🚀 Guide d'Installation pour les Membres du Groupe

Chaque membre du groupe doit suivre ces étapes pour lancer le projet en local :

### 1. Prérequis
- **PHP** >= 8.2 (avec extensions pdo, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo)
- **Composer** (Gestionnaire de dépendances PHP)
- **Git**
- **MySQL / MariaDB** (ou SQLite pour les tests rapides)

### 2. Cloner le dépôt
```bash
git clone <URL_DU_REPO_GITHUB>
cd eneam-pv-deliberation
```

### 3. Installer les dépendances PHP
```bash
composer install
```

### 4. Configurer l'environnement local
```bash
cp .env.example .env
php artisan key:generate
```

Éditez le fichier `.env` pour configurer votre base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eneam_pv_db
DB_USERNAME=root
DB_PASSWORD=
```
*(Si vous préférez SQLite en local, laissez `DB_CONNECTION=sqlite` et créez le fichier `database/database.sqlite`)*.

### 5. Lancer les migrations
```bash
php artisan migrate
```

### 6. Créer le lien symbolique pour le stockage des fichiers scannés
```bash
php artisan storage:link
```

### 7. Démarrer le serveur local
```bash
php artisan serve
```
L'application sera accessible sur `http://localhost:8000`.

---

## 🌿 Règles de Collaboration Git

Pour éviter les conflits de code entre les membres de l'équipe :

1. **Ne jamais commiter directement sur `main`**.
2. Travailler sur des branches de fonctionnalités (features) :
   ```bash
   git checkout -b feature/nom-de-votre-tache
   ```
3. Avant d'écrire du code, mettez à jour votre branche :
   ```bash
   git pull origin main
   ```
4. Une fois votre tâche testée et validée en local :
   ```bash
   git add .
   git commit -m "feat: description claire de ce qui a été fait"
   git push origin feature/nom-de-votre-tache
   ```
5. Créer une **Pull Request (PR)** sur GitHub pour fusionner votre branche.

---

## 🛠️ Stack Technique

- **Framework** : Laravel 11/12
- **Langage** : PHP 8.4
- **ORM** : Eloquent
- **Frontend** : Blade / Tailwind CSS
- **Base de données** : MySQL / SQLite
