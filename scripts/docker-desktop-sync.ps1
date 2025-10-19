# Docker Desktop Synchronization Script
# Ce script permet de synchroniser et detecter automatiquement les conteneurs dans Docker Desktop

param(
    [Parameter(Mandatory=$false)]
    [string]$Action = "sync"
)

# Configuration
$ProjectName = "projet-laravel-yassineroube"
$DockerHubUsername = $env:DOCKER_HUB_USERNAME
$ComposeFile = "docker-compose.yml"

# Fonction pour afficher les messages avec couleurs
function Write-ColorOutput($ForegroundColor) {
    $fc = $host.UI.RawUI.ForegroundColor
    $host.UI.RawUI.ForegroundColor = $ForegroundColor
    if ($args) {
        Write-Output $args
    } else {
        $input | Write-Output
    }
    $host.UI.RawUI.ForegroundColor = $fc
}

function Write-Info($message) {
    Write-ColorOutput Cyan "INFO: $message"
}

function Write-Success($message) {
    Write-ColorOutput Green "SUCCESS: $message"
}

function Write-Warning($message) {
    Write-ColorOutput Yellow "WARNING: $message"
}

function Write-Error($message) {
    Write-ColorOutput Red "ERROR: $message"
}

# Fonction pour verifier si Docker Desktop est en cours d'execution
function Test-DockerDesktop {
    try {
        $dockerInfo = docker info 2>$null
        if ($LASTEXITCODE -eq 0) {
            Write-Success "Docker Desktop est en cours d'execution"
            return $true
        }
    } catch {
        Write-Error "Docker Desktop n'est pas accessible"
        return $false
    }
    return $false
}

# Fonction pour recuperer les images depuis Docker Hub
function Get-DockerHubImages {
    Write-Info "Recuperation des images depuis Docker Hub..."
    
    if (-not $DockerHubUsername) {
        Write-Warning "DOCKER_HUB_USERNAME n'est pas defini. Utilisation du nom par defaut."
        $DockerHubUsername = "yassineroube"
    }
    
    try {
        # Recuperer l'image principale
        Write-Info "Telechargement de l'image principale..."
        docker pull "$DockerHubUsername/projet-laravel:latest"
        
        # Recuperer les images de base necessaires
        Write-Info "Telechargement des images de base..."
        docker pull mysql:8.0
        docker pull redis:7-alpine
        docker pull prom/prometheus:latest
        docker pull grafana/grafana:latest
        docker pull prom/node-exporter:latest
        docker pull mailhog/mailhog:latest
        
        Write-Success "Images telechargees avec succes"
    } catch {
        Write-Error "Erreur lors du telechargement des images: $_"
    }
}

# Fonction pour demarrer les conteneurs avec Docker Compose
function Start-DockerContainers {
    Write-Info "Demarrage des conteneurs avec Docker Compose..."
    
    if (-not (Test-Path $ComposeFile)) {
        Write-Error "Fichier $ComposeFile introuvable"
        return
    }
    
    try {
        # Arreter les conteneurs existants
        Write-Info "Arret des conteneurs existants..."
        docker compose down --remove-orphans
        
        # Demarrer les nouveaux conteneurs
        Write-Info "Demarrage des nouveaux conteneurs..."
        docker compose up -d
        
        # Attendre que les services soient prets
        Write-Info "Attente du demarrage des services..."
        Start-Sleep -Seconds 30
        
        # Verifier l'etat des conteneurs
        Write-Info "Verification de l'etat des conteneurs..."
        docker compose ps
        
        Write-Success "Conteneurs demarres avec succes"
    } catch {
        Write-Error "Erreur lors du demarrage des conteneurs: $_"
    }
}

# Fonction pour verifier la sante des services
function Test-ServicesHealth {
    Write-Info "Verification de la sante des services..."
    
    $services = @(
        @{Name="Laravel App"; Url="http://localhost:8080"; Port=8080},
        @{Name="MySQL"; Url="localhost:3306"; Port=3306},
        @{Name="Redis"; Url="localhost:6379"; Port=6379},
        @{Name="Prometheus"; Url="http://localhost:9090/-/healthy"; Port=9090},
        @{Name="Grafana"; Url="http://localhost:3000/api/health"; Port=3000},
        @{Name="Node Exporter"; Url="http://localhost:9100"; Port=9100},
        @{Name="MailHog"; Url="http://localhost:8025"; Port=8025}
    )
    
    foreach ($service in $services) {
        try {
            if ($service.Name -eq "MySQL" -or $service.Name -eq "Redis") {
                # Test de connexion TCP pour MySQL et Redis
                $tcpClient = New-Object System.Net.Sockets.TcpClient
                $tcpClient.ConnectAsync("localhost", $service.Port).Wait(5000)
                if ($tcpClient.Connected) {
                    Write-Success "$($service.Name) est accessible sur le port $($service.Port)"
                } else {
                    Write-Warning "$($service.Name) n'est pas accessible sur le port $($service.Port)"
                }
                $tcpClient.Close()
            } else {
                # Test HTTP pour les autres services
                $response = Invoke-WebRequest -Uri $service.Url -TimeoutSec 10 -UseBasicParsing
                if ($response.StatusCode -eq 200) {
                    Write-Success "$($service.Name) est accessible a $($service.Url)"
                } else {
                    Write-Warning "$($service.Name) repond avec le code $($response.StatusCode)"
                }
            }
        } catch {
            Write-Warning "$($service.Name) n'est pas accessible: $($_.Exception.Message)"
        }
    }
}

# Fonction pour afficher les informations des conteneurs
function Show-ContainerInfo {
    Write-Info "Informations des conteneurs Docker Desktop:"
    
    Write-Host "`nImages disponibles:" -ForegroundColor Cyan
    docker images --format "table {{.Repository}}\t{{.Tag}}\t{{.Size}}\t{{.CreatedSince}}"
    
    Write-Host "`nConteneurs en cours d'execution:" -ForegroundColor Cyan
    docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
    
    Write-Host "`nUtilisation des ressources:" -ForegroundColor Cyan
    docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}"
    
    Write-Host "`nServices accessibles:" -ForegroundColor Cyan
    Write-Host "  • Application Laravel: http://localhost:8080" -ForegroundColor Green
    Write-Host "  • Prometheus: http://localhost:9090" -ForegroundColor Green
    Write-Host "  • Grafana: http://localhost:3000 (admin/admin123)" -ForegroundColor Green
    Write-Host "  • MailHog: http://localhost:8025" -ForegroundColor Green
    Write-Host "  • Node Exporter: http://localhost:9100" -ForegroundColor Green
}

# Fonction principale de synchronisation
function Sync-DockerDesktop {
    Write-Info "Demarrage de la synchronisation Docker Desktop..."
    
    # Verifier Docker Desktop
    if (-not (Test-DockerDesktop)) {
        Write-Error "Veuillez demarrer Docker Desktop avant de continuer"
        exit 1
    }
    
    # Recuperer les images
    Get-DockerHubImages
    
    # Demarrer les conteneurs
    Start-DockerContainers
    
    # Verifier la sante des services
    Test-ServicesHealth
    
    # Afficher les informations
    Show-ContainerInfo
    
    Write-Success "Synchronisation terminee avec succes!"
    Write-Info "Vos conteneurs sont maintenant visibles dans Docker Desktop"
}

# Fonction pour nettoyer les ressources
function Clean-DockerResources {
    Write-Info "Nettoyage des ressources Docker..."
    
    try {
        # Arreter tous les conteneurs
        docker compose down --remove-orphans
        
        # Nettoyer les images non utilisees
        docker image prune -f
        
        # Nettoyer les volumes non utilises
        docker volume prune -f
        
        # Nettoyer les reseaux non utilises
        docker network prune -f
        
        Write-Success "Nettoyage termine"
    } catch {
        Write-Error "Erreur lors du nettoyage: $_"
    }
}

# Execution principale
switch ($Action.ToLower()) {
    "sync" { Sync-DockerDesktop }
    "pull" { Get-DockerHubImages }
    "start" { Start-DockerContainers }
    "health" { Test-ServicesHealth }
    "info" { Show-ContainerInfo }
    "clean" { Clean-DockerResources }
    default {
        Write-Info "Usage: .\docker-desktop-sync.ps1 [-Action <sync|pull|start|health|info|clean>] [-Verbose]"
        Write-Info "Actions disponibles:"
        Write-Info "  sync   - Synchronisation complete (par defaut)"
        Write-Info "  pull   - Telecharger les images depuis Docker Hub"
        Write-Info "  start  - Demarrer les conteneurs"
        Write-Info "  health - Verifier la sante des services"
        Write-Info "  info   - Afficher les informations des conteneurs"
        Write-Info "  clean  - Nettoyer les ressources Docker"
    }
}