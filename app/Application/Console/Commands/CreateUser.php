<?php

namespace App\Application\Console\Commands;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    protected $signature = 'test:create-user {name} {email} {password} {role}';

    protected $description = 'Crea un usuario de prueba';

    public function handle(): void
    {
        $this->info('Comando funcionando!');
    }
}
