<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;

class GuardarNotas
{
    public function __construct(
        private readonly IRegistroRepository $registroRepository,
    ) {}

    public function execute(array $data)
    {
        foreach ($data as $item) {
            $registro = $this->registroRepository->getById(Id::fromInt($item['registro_id']));

            $registro->update($item['notas'] ?? []);

            $this->registroRepository->save($registro);
        }
    }
}
