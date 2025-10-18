# CI/CD Pipeline Documentation

## Overview

This project implements a comprehensive CI/CD pipeline using GitHub Actions that includes automated testing, security scanning, code quality analysis, Docker image building, and deployment automation.

## Pipeline Components

### 1. Security & Code Quality Analysis
- **PHP Security Checker**: Scans for known security vulnerabilities in dependencies
- **PHP Code Sniffer**: Enforces PSR-12 coding standards
- **SonarQube Integration**: Comprehensive code quality and security analysis
- **Trivy Scanner**: Container vulnerability scanning

### 2. Automated Testing
- **PHPUnit Tests**: Unit and feature tests with coverage reporting
- **Database Testing**: MySQL and Redis service containers
- **Coverage Reports**: XML and HTML coverage reports uploaded to Codecov

### 3. Docker Integration
- **Multi-platform Builds**: Supports AMD64 and ARM64 architectures
- **Container Registry**: Uses GitHub Container Registry (GHCR)
- **Image Caching**: Optimized build times with GitHub Actions cache
- **Security Scanning**: Trivy vulnerability scanner for built images

### 4. Deployment
- **Environment Protection**: Production deployments require manual approval
- **Health Checks**: Automated health verification after deployment
- **Rollback Capability**: Automatic rollback on deployment failure



## Required Secrets

Configure the following secrets in your GitHub repository:

### SonarQube
- `SONAR_TOKEN`: SonarQube authentication token
- `SONAR_HOST_URL`: SonarQube server URL

### Deployment (Optional)
- Add deployment-specific secrets as needed for your infrastructure

## Workflow Triggers

### Automatic Triggers
- **Push to main/develop**: Full CI/CD pipeline
- **Pull Requests**: Testing and security scanning only
- **Schedule**: Weekly security scans (Mondays at 2 AM)

### Manual Triggers
- **Workflow Dispatch**: Manual pipeline execution
- **Security Scan**: On-demand security analysis

## Performance Optimizations

### Caching Strategy
- **Composer Dependencies**: Cached based on `composer.lock` hash
- **Node Modules**: NPM cache for faster builds
- **Docker Layers**: GitHub Actions cache for Docker builds

### Parallel Execution
- Security scanning runs independently
- Testing waits for security approval
- Build/deploy stages run sequentially for safety

### Resource Optimization
- Uses official GitHub-hosted runners
- Optimized Docker builds with multi-stage approach
- Minimal service containers for testing

## Security Best Practices

### Code Protection
- **CODEOWNERS**: Enforced code review requirements
- **Dependabot**: Automated dependency updates
- **Branch Protection**: Required status checks and reviews

### Secret Management
- All sensitive data stored as GitHub secrets
- No hardcoded credentials in workflow files
- Minimal permission scopes for actions

### Container Security
- **Trivy Scanning**: Vulnerability detection in images
- **Multi-stage Builds**: Minimal production images
- **Non-root User**: Containers run with restricted privileges

## File Structure

```
.github/
├── workflows/
│   ├── ci-cd.yml           # Main CI/CD pipeline
│   └── security-scan.yml   # Dedicated security scanning
├── CODEOWNERS              # Code review requirements
└── dependabot.yml          # Dependency update automation

sonar-project.properties    # SonarQube configuration
phpunit.xml                 # PHPUnit test configuration
```

## Usage Instructions

### Initial Setup
1. Configure required secrets in GitHub repository settings
2. Update team names in CODEOWNERS file
3. Customize SonarQube project settings
4. Configure deployment targets in the deploy job

### Development Workflow
1. Create feature branch from `develop`
2. Make changes and push commits
3. Create pull request to `develop`
4. Pipeline runs tests and security checks
5. After approval, merge to `develop`
6. For releases, merge `develop` to `main`
7. Production deployment triggers automatically

### Monitoring
- Check GitHub Actions tab for pipeline status
- Review SonarQube dashboard for code quality metrics

## Troubleshooting

### Common Issues
1. **Test Failures**: Check database connectivity and migrations
2. **Build Failures**: Verify Docker configuration and dependencies
3. **Security Scan Issues**: Update vulnerable dependencies
4. **Deployment Failures**: Check environment configuration and secrets

### Debug Steps
1. Review GitHub Actions logs
2. Check service container health
3. Verify secret configuration
4. Test locally with Docker Compose

## Customization

### Adding New Tests
- Add test files to `tests/` directory
- Update PHPUnit configuration if needed
- Tests run automatically in pipeline

### Modifying Security Scans
- Update security tools in workflow
- Configure additional scanners as needed
- Adjust security thresholds in SonarQube

### Deployment Customization
- Update deployment commands in deploy job
- Add environment-specific configurations
- Configure additional deployment targets

## Support

For issues with the CI/CD pipeline:
1. Check this documentation
2. Review GitHub Actions logs
3. Contact the DevOps team
4. Create an issue in the repository