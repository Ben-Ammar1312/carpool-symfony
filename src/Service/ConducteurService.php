<?php

namespace App\Service;

use App\Entity\Conducteur;
use App\Repository\ConducteurRepository;

class ConducteurService
{
    private ConducteurRepository $conducteurRepository;

    public function __construct(ConducteurRepository $conducteurRepository)
    {
        $this->conducteurRepository = $conducteurRepository;
    }

    /**
     * Retrieve all Conducteur entities.
     *
     * @return Conducteur[]
     */
    public function getAllConducteur(): array
    {
        return $this->conducteurRepository->findAll();
    }
}
