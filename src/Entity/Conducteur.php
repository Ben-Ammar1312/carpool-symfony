<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity]
class Conducteur extends Utilisateur
{
    // Ajoutez des propriétés spécifiques aux conducteurs si nécessaire
}
