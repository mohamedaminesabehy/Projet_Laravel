@echo off
REM Script batch pour déployer automatiquement l'image Docker localement
REM Usage: deploy-local.bat [tag]

setlocal enabledelayedexpansion

set DOCKER_HUB_USERNAME=mohamedaminesabehy
set IMAGE_NAME=projet-laravel
set TAG=%1
if "%TAG%"=="" set TAG=latest
set CONTAINER_NAME=projet-laravel-app
set PORT=8080

echo.
echo ================================
echo   DEPLOIEMENT LOCAL DOCKER
echo ================================
echo.
echo Repository: %DOCKER_HUB_USERNAME%/%IMAGE_NAME%:%TAG%
echo Port local: %PORT%
echo.

REM Vérifier si Docker Desktop est en cours d'exécution
docker version >nul 2>&1
if errorlevel 1 (
    echo [ERREUR] Docker Desktop n'est pas en cours d'execution.
    echo Veuillez demarrer Docker Desktop et reessayer.
    pause
    exit /b 1
)

echo [INFO] Docker Desktop detecte - OK
echo.

REM Arrêter et supprimer le conteneur existant s'il existe
echo [INFO] Nettoyage des conteneurs existants...
docker stop %CONTAINER_NAME% >nul 2>&1
docker rm %CONTAINER_NAME% >nul 2>&1

REM Supprimer l'ancienne image
echo [INFO] Suppression de l'ancienne image...
docker rmi %DOCKER_HUB_USERNAME%/%IMAGE_NAME%:%TAG% >nul 2>&1

REM Télécharger la nouvelle image
echo [INFO] Telechargement de la nouvelle image...
docker pull %DOCKER_HUB_USERNAME%/%IMAGE_NAME%:%TAG%
if errorlevel 1 (
    echo [ERREUR] Echec du telechargement de l'image
    pause
    exit /b 1
)

echo [SUCCESS] Image telechargee avec succes!
echo.

REM Démarrer le nouveau conteneur
echo [INFO] Demarrage du conteneur...
docker run -d ^
    --name %CONTAINER_NAME% ^
    -p %PORT%:80 ^
    --restart unless-stopped ^
    %DOCKER_HUB_USERNAME%/%IMAGE_NAME%:%TAG%

if errorlevel 1 (
    echo [ERREUR] Echec du demarrage du conteneur
    pause
    exit /b 1
)

echo.
echo ================================
echo   DEPLOIEMENT TERMINE!
echo ================================
echo.
echo Application disponible sur: http://localhost:%PORT%
echo Nom du conteneur: %CONTAINER_NAME%
echo.
echo Commandes utiles:
echo   - Voir les logs: docker logs %CONTAINER_NAME%
echo   - Arreter: docker stop %CONTAINER_NAME%
echo   - Redemarrer: docker restart %CONTAINER_NAME%
echo.

REM Ouvrir automatiquement le navigateur
timeout /t 3 /nobreak >nul
start http://localhost:%PORT%

pause