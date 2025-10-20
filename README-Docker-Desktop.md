# Guide de Synchronisation Docker Desktop

Ce guide vous explique comment synchroniser vos conteneurs et images avec Docker Desktop pour les rendre visibles localement.

## 🎯 Problème Résolu

Lorsque le pipeline CI/CD s'exécute sur GitHub Actions, les conteneurs et images sont créés sur les runners distants et ne sont pas visibles dans votre Docker Desktop local. Cette solution permet de :

- ✅ Télécharger automatiquement les images depuis Docker Hub
- ✅ Démarrer les conteneurs localement
- ✅ Les rendre visibles dans Docker Desktop
- ✅ Configurer le monitoring (Prometheus + Grafana)
- ✅ Vérifier la santé des services

## 🚀 Méthodes de Synchronisation

### Méthode 1: Script PowerShell (Recommandée)

#### Utilisation Rapide
```powershell
# Synchronisation complète
.\scripts\docker-desktop-sync.ps1

# Ou avec des options spécifiques
.\scripts\docker-desktop-sync.ps1 -Action sync -Verbose
```

#### Actions Disponibles
```powershell
# Télécharger uniquement les images
.\scripts\docker-desktop-sync.ps1 -Action pull

# Démarrer les conteneurs
.\scripts\docker-desktop-sync.ps1 -Action start

# Vérifier la santé des services
.\scripts\docker-desktop-sync.ps1 -Action health

# Afficher les informations
.\scripts\docker-desktop-sync.ps1 -Action info

# Nettoyer les ressources
.\scripts\docker-desktop-sync.ps1 -Action clean
```

### Méthode 2: Pipeline CI/CD Local

#### Prérequis
1. Installer [act](https://github.com/nektos/act) pour l'exécution locale des workflows GitHub Actions
2. Docker Desktop doit être en cours d'exécution

#### Exécution
```bash
# Note: La tâche local-docker-desktop-sync a été supprimée du pipeline CI/CD
# Utilisez plutôt les scripts locaux pour la synchronisation Docker Desktop
```

### Méthode 3: GitHub Actions avec Self-Hosted Runner

#### Configuration
1. Aller dans Settings > Actions > Runners de votre repository
2. Cliquer sur "New self-hosted runner"
3. Suivre les instructions pour Windows
4. Démarrer le runner sur votre machine locale

#### Exécution
1. Aller dans l'onglet "Actions" de votre repository
2. Sélectionner "CI/CD Pipeline"
3. Cliquer sur "Run workflow"
4. Choisir "local" comme environnement
5. Lancer le workflow

## 🌐 Services Accessibles

Après la synchronisation, vous pouvez accéder aux services suivants :

| Service | URL | Identifiants |
|---------|-----|--------------|
| **Application Laravel** | http://localhost:8080 | - |
| **Prometheus** | http://localhost:9090 | - |
| **Grafana** | http://localhost:3000 | admin / admin123 |
| **MailHog** | http://localhost:8025 | - |
| **Node Exporter** | http://localhost:9100 | - |
| **phpMyAdmin** | http://localhost:8081 | root / password |

## 📊 Monitoring avec Grafana

### Accès au Dashboard
1. Ouvrir http://localhost:3000
2. Se connecter avec `admin` / `admin123`
3. Aller dans **Dashboards** > **Laravel Monitoring**

### Métriques Disponibles
- 📈 Utilisation CPU et Mémoire
- 🌐 Statut de l'application
- 💾 I/O Disque
- 🔄 Métriques Redis
- 🗄️ Métriques MySQL

## 🛠️ Commandes Utiles

### Docker Compose
```bash
# Voir l'état des conteneurs
docker compose ps

# Voir les logs en temps réel
docker compose logs -f

# Redémarrer un service spécifique
docker compose restart app

# Arrêter tous les services
docker compose down

# Redémarrer tous les services
docker compose up -d
```

### Docker Desktop
```bash
# Voir toutes les images
docker images

# Voir tous les conteneurs
docker ps -a

# Voir l'utilisation des ressources
docker stats

# Nettoyer les ressources inutilisées
docker system prune -f
```

## 🔧 Dépannage

### Docker Desktop ne démarre pas
```powershell
# Vérifier le statut
docker info

# Redémarrer Docker Desktop
Restart-Service docker
```

### Les conteneurs ne démarrent pas
```powershell
# Vérifier les logs
docker compose logs

# Reconstruire les images
docker compose build --no-cache

# Nettoyer et redémarrer
docker compose down --volumes
docker compose up -d
```

### Ports déjà utilisés
```powershell
# Voir les ports utilisés
netstat -an | findstr :8080

# Arrêter les processus utilisant le port
Stop-Process -Id (Get-NetTCPConnection -LocalPort 8080).OwningProcess -Force
```

### Images non trouvées sur Docker Hub
```powershell
# Vérifier la connexion Docker Hub
docker login

# Construire l'image localement
docker compose build app

# Pousser vers Docker Hub
docker push yassineroube/projet-laravel:latest
```

## 📝 Configuration Avancée

### Variables d'Environnement
Créer un fichier `.env.local` :
```env
DOCKER_HUB_USERNAME=votre-username
PROJECT_NAME=votre-projet
APP_PORT=8080
PROMETHEUS_PORT=9090
GRAFANA_PORT=3000
```

### Personnalisation des Services
Modifier `docker-compose.yml` pour ajuster :
- Les ports exposés
- Les volumes persistants
- Les variables d'environnement
- Les limites de ressources

## 🎉 Résultat Attendu

Après une synchronisation réussie, vous devriez voir dans Docker Desktop :

### Images
- ✅ yassineroube/projet-laravel:latest
- ✅ mysql:8.0
- ✅ redis:7-alpine
- ✅ prom/prometheus:latest
- ✅ grafana/grafana:latest
- ✅ prom/node-exporter:latest
- ✅ mailhog/mailhog:latest

### Conteneurs
- ✅ projet_laravel-yassineroube-app-1
- ✅ projet_laravel-yassineroube-mysql-1
- ✅ projet_laravel-yassineroube-redis-1
- ✅ projet_laravel-yassineroube-prometheus-1
- ✅ projet_laravel-yassineroube-grafana-1
- ✅ projet_laravel-yassineroube-node-exporter-1
- ✅ projet_laravel-yassineroube-mailhog-1

## 📞 Support

Si vous rencontrez des problèmes :

1. Vérifiez que Docker Desktop est en cours d'exécution
2. Consultez les logs avec `docker compose logs`
3. Exécutez le script de diagnostic : `.\scripts\docker-desktop-sync.ps1 -Action health`
4. Nettoyez les ressources : `.\scripts\docker-desktop-sync.ps1 -Action clean`

---

**Note**: Cette solution est spécialement conçue pour Windows avec PowerShell et Docker Desktop.