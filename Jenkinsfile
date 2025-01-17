pipeline {
    agent any

    environment {
        REPO_URL            = 'https://github.com/abdallh249/linux.git'
        DOCKER_BUILDKIT     = '1'
        MYSQL_ROOT_PASSWORD = '123'
        MYSQL_DATABASE      = 'mydb'
    }

    stages {

        stage('Checkout') {
            steps {
                script {
                    // Pull the code from your GitHub repository
                    checkout([
                        $class: 'GitSCM',
                        branches: [[name: '*/main']], 
                        userRemoteConfigs: [[url: env.REPO_URL]]
                    ])
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    // Build Docker images as defined in docker-compose.yml
                    // Using --no-cache is optional but can help avoid caching issues
                    sh 'docker-compose build --no-cache'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    // (Optional) Example test command inside the 'web' container
                    // If you don't have a test file yet, comment out or remove this step
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
