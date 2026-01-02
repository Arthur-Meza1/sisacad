pipeline {
  agent any

  stages {
    stage('Validar Entorno') {
      steps {
        sh 'docker ps'
      }
    }

    stage('Ejecutar Tests (Pest)') {
      steps {
        sh 'docker exec pro-laravel.test-1 php artisan test'
      }
    }

    stage('Análisis de Estilo') {
      steps {
        sh 'docker exec pro-laravel.test-1 ./vendor/bin/pint --test'
      }
    }
  }

  post {
    success {
      echo '¡Build exitoso! Todos los tests pasaron.'
    }
    failure {
      echo 'El build falló. Revisa los tests o el formato del código.'
    }
  }
}
