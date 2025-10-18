#!/usr/bin/env pwsh
# Script PowerShell pour télécharger automatiquement la dernière image Docker

param(
    [string]$DockerHubUsername = "mohamedaminesabehy",
    [string]$ImageName = "projet-laravel",
    [string]$Tag = "latest"
)

Write-Host "🐳 Téléchargement de la dernière image Docker..." -ForegroundColor Cyan
Write-Host "Repository: $DockerHubUsername/$ImageName:$Tag" -ForegroundColor Yellow

try {
    # Vérifier si Docker Desktop est en cours d'exécution
    $dockerStatus = docker version 2>$null
    if ($LASTEXITCODE -ne 0) {
        Write-Host "❌ Docker Desktop n'est pas en cours d'exécution. Veuillez le démarrer." -ForegroundColor Red
        exit 1
    }

    # Supprimer l'ancienne image si elle existe
    Write-Host "🧹 Nettoyage des anciennes images..." -ForegroundColor Yellow
    docker rmi "$DockerHubUsername/$ImageName`:$Tag" 2>$null

    # Télécharger la nouvelle image
    Write-Host "⬇️ Téléchargement de l'image depuis Docker Hub..." -ForegroundColor Green
    docker pull "$DockerHubUsername/$ImageName`:$Tag"
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Image téléchargée avec succès!" -ForegroundColor Green
        Write-Host "📋 Informations sur l'image:" -ForegroundColor Cyan
        docker images "$DockerHubUsername/$ImageName"
        
        Write-Host "`n🚀 Pour démarrer le conteneur, utilisez:" -ForegroundColor Yellow
        Write-Host "docker run -d -p 8080:80 --name projet-laravel $DockerHubUsername/$ImageName`:$Tag" -ForegroundColor White
    } else {
        Write-Host "❌ Échec du téléchargement de l'image" -ForegroundColor Red
        exit 1
    }
} catch {
    Write-Host "❌ Erreur: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}