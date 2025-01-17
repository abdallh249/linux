pipeline {
    
    agent any

    
    environment {
        REPO_URL = https://github.com/abdallh249/linux
        DOCKER_BUILDKIT = '1'
        MYSQL_ROOT_PASSWORD = '123'
        MYSQL_DATABASE = 'mydb'
    }

    stages {

        stage('Checkout') {
            steps {
                // Pull the code from your GitHub repository
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/main']], // Change if you use a different branch
                    userRemoteConfigs: [[url: 'https://github.com/abdallh249/linux.git']]
                ])
            }
        }

        stage('Build') {
            steps {
                script {
                    // Build Docker images as defined in docker-compose.yml
                    sh 'docker-compose build'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    // (Optional) Example test command inside the 'web' container
                    // Adjust or remove if you have a different test procedure
                    sh 'docker-compose run --rm web php /var/www/html/your-test-file.php'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    // Bring up containers in detached mode
                    sh 'docker-compose up -d'
                }
            }
        }
    }
}
