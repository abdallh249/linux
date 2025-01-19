pipeline {
    agent any

    environment {
        REPO_URL            = 'https://github.com/abdallh249/linux.git'
        DOCKER_BUILDKIT     = '1'
        MYSQL_ROOT_PASSWORD = '123'
        MYSQL_DATABASE      = 'mydb'
        COMPOSE_PATH        = '/usr/local/bin/docker-compose'
    }

    stages {

        stage('Checkout') {
            steps {
                script {
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
                    sh '''
                        if ! command -v docker-compose &> /dev/null
                        then
                            echo "Docker Compose not found. Installing..."
                            curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-Linux-x86_64" \
                                -o $COMPOSE_PATH
                            chmod +x $COMPOSE_PATH
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
                    sh 'docker-compose build --no-cache'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    sh 'docker-compose run --rm web php /var/www/html/your-test-file.php'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    sh 'docker-compose up -d'
                }
            }
        }
    }
}
