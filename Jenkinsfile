pipeline {
  agent any

  environment {
    APP_ENV = 'testing'
    DB_CONNECTION = 'sqlite'
    DB_DATABASE = ':memory:'
  }

  stages {
    stage('Validar y Preparar') {
      steps {
        echo 'Verificando contenedores activos...'
        sh 'docker ps'

        echo 'Instalando dependencias de Composer...'
        sh 'docker exec pro-laravel.test-1 composer install --no-interaction --prefer-dist --optimize-autoloader'
      }
    }

    stage('Estilo de Código (Pint)') {
      steps {
        echo 'Ejecutando Laravel Pint...'
        // Si alguien sube código mal formateado, el pipeline se detendrá aquí
        sh 'docker exec pro-laravel.test-1 ./vendor/bin/pint --test'
      }
    }

    stage('Tests (Pest)') {
      steps {
        echo 'Ejecutando tests de Pest...'
        // Usamos "php artisan test" que es el comando estándar de Laravel 12
        sh 'docker exec pro-laravel.test-1 php artisan test --parallel'
      }
    }
  }

  post {
    success {
      echo ' ¡Build Exitoso! El código cumple con los estándares y los tests pasaron.'
    }
    failure {
      echo ' El build ha fallado. Revisa la salida de la consola para ver qué test falló.'
    }
    always {
      echo 'Limpiando archivos temporales...'
      // Opcional: limpiar caché si fuera necesario
    }
  }
}
