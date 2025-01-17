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

        stage('Install Docker Compose') {
            steps {
                script {
                    // Install docker-compose at runtime if it's not present
                    sh '''
                        if ! command -v docker-compose &> /dev/null
                        then
                            echo "Docker Compose not found. Installing..."
                            curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" \
                                -o /usr/local/bin/docker-compose
                            chmod +x /usr/local/bin/docker-compose
                            echo "Docker Compose installed successfully."
                        else
                            echo "Docker Compose is already installed."
                        fi
                    '''
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    // Build Docker images as defined in docker-compose.yml
                    sh 'docker-compose build --no-cache'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    // (Optional) Run a test command inside the 'web' container
                    // Comment out if you don't have a test file
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
