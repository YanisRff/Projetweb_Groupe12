# Gulf Traject - Guide de démarrage complet

Ce guide détaille l’installation de Docker, la configuration et le lancement de l’environnement de développement du projet **Gulf Traject**.

---

## 1. Installation de Docker et Docker Compose

### ⚠️ Ces étapes supposent un ordinateur **ne disposant pas encore de Docker**.

---

### 1.1 Windows (avec WSL Debian)

Si vous êtes sous Windows, nous recommandons d’utiliser **WSL 2** avec une distribution Debian.

#### Étape 1 : Installer WSL et Debian

Ouvrez PowerShell en mode administrateur et lancez :

```powershell
wsl --install
wsl --set-default-version 2
wsl --install -d Debian
````

Redémarrez votre PC si demandé. Lancez ensuite Debian depuis le menu démarrer.

#### Étape 2 : Installer Docker dans WSL Debian

Dans le terminal Debian :

```bash
# Mettre à jour la liste des paquets
sudo apt-get update

# Installer les paquets nécessaires pour HTTPS
sudo apt-get install -y apt-transport-https ca-certificates curl gnupg lsb-release

# Ajouter la clé GPG officielle de Docker
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

# Ajouter le dépôt Docker stable
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/debian \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Mettre à jour la liste des paquets
sudo apt-get update

# Installer Docker et Docker Compose
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Ajouter votre utilisateur au groupe docker (pour éviter d'utiliser sudo)
sudo usermod -aG docker $USER

# Déconnectez-vous puis reconnectez-vous dans WSL pour appliquer les changements
```

---

### 1.2 Debian / Ubuntu (installation native)

Dans un terminal, exécutez :

```bash
sudo apt-get update
sudo apt-get install -y apt-transport-https ca-certificates curl gnupg lsb-release

sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/debian \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

sudo usermod -aG docker $USER

# Se déconnecter puis reconnecter pour que le groupe docker soit pris en compte
```

---

### 1.3 Arch Linux

Dans un terminal :

```bash
sudo pacman -Syu
sudo pacman -S docker docker-compose

sudo systemctl start docker.service
sudo systemctl enable docker.service

sudo usermod -aG docker $USER

# Déconnectez-vous et reconnectez-vous pour appliquer les droits docker
```

---

## 2. Structure du projet

Le projet est organisé comme suit :

```
.
├── assets/
│   ├── css/
│   ├── images/
│   ├── js/
│   ├── models/
│   └── py/
│       └── fillDB.py
├── compose.yaml
├── docker/
│   └── apache-custom.conf
├── Dockerfile
├── index.php
├── php/
│   ├── constants.php
│   ├── database.php
│   └── ...
├── sql/
│   └── sql.sql
└── src/
    ├── globals/
    └── pages/
```

* `Dockerfile` : définit l’image Docker du service web PHP.
* `compose.yaml` : orchestration des services (website, base de données), réseaux, volumes.
* `docker/apache-custom.conf` : configuration personnalisée d’Apache.
* `php/constants.php` : paramètres de connexion à la base de données.
* `assets/py/fillDB.py` : script Python pour initialiser la base de données.

---

## 3. Configuration de la base de données

Dans `php/constants.php`, vérifiez que les paramètres de connexion correspondent au service Docker `db` :

```php
<?php
// Fichier: php/constants.php

// Le nom d'hôte 'db' correspond au nom du service dans compose.yaml
define('DB_SERVEUR', 'db');
define('DB_PORT', '5432');
define('DB_NAME', 'db');
define('DB_USER', 'yanis');
define('DB_PASSWORD', 'a');
?>
```

> ⚠️ **Important** :
> N’utilisez pas la commande `docker inspect` pour récupérer l’IP du conteneur de base de données.
> Ces IP changent à chaque redémarrage. Utilisez toujours le nom du service `db`.

---

## 4. Lancement de l’environnement Docker

Placez-vous à la racine du projet, puis lancez la commande :

```bash
docker compose up --build -d
```

* `up` : crée et démarre les conteneurs.
* `--build` : force la reconstruction de l’image du service `website` à partir du `Dockerfile`.
* `-d` : lance en mode détaché (arrière-plan).

---

## 5. Initialisation de la base de données

Après démarrage des conteneurs, la base de données est vide. Pour la peupler, exécutez le script Python :

* Sous **Windows (WSL)** :

```bash
python3 assets/py/fillDB.py
```

* Sous **Linux (Debian, Arch, etc.)** :

```bash
python assets/py/fillDB.py
```

---

## 6. Accès aux services

| Service             | Détails                                      |
| ------------------- | -------------------------------------------- |
| **Site Web**        | Accessible sur `http://localhost:8080`       |
| **Base de données** | Depuis la machine hôte, connectez-vous sur : |
|                     | - Hôte : `localhost`                         |
|                     | - Port : `5432`                              |
|                     | - Base : `db`                                |
|                     | - Utilisateur : `yanis`                      |
|                     | - Mot de passe : `a`                         |

---

### 6.1 Accès au terminal du conteneur web

Pour du débogage ou commandes internes, ouvrez un shell dans le conteneur web :

```bash
docker compose exec gulf_traject_web /bin/bash
```

---

## 7. Commandes Docker utiles

* Afficher les logs en temps réel (utile pour le débogage) :

```bash
docker compose logs -f
```

* Arrêter les conteneurs sans les supprimer :

```bash
docker compose stop
```

* Arrêter et supprimer les conteneurs et réseaux (le volume `db-data` est conservé par défaut) :

```bash
docker compose down
```

```

---

Veux-tu que je te génère aussi un `.gitignore` adapté au projet ?  
Ou un fichier `.env` pour faciliter la config des variables d’environnement ?
```

