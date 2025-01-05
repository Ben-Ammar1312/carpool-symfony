<?php

namespace App\Security;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

abstract class UserDetailsService implements UserProviderInterface
{
    private Utilisateur $userRepository;

    public function __construct(UtilisateurRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Load a user by their username (email in this case).
     *
     * @param string $email The email used as the username.
     * @return UserInterface The loaded user.
     * @throws UsernameNotFoundException If the user is not found.
     */
    public function loadUserByUsername(string $email): UserInterface
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('User not found with email: %s', $email));
        }

        return $user; // Ensure User implements UserInterface
    }

    /**
     * Refreshes the user entity.
     *
     * @param UserInterface $user The user to refresh.
     * @return UserInterface The refreshed user.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Utilisateur) {
            throw new \InvalidArgumentException(sprintf('Invalid user class: %s', get_class($user)));
        }

        return $this->userRepository->find($user->getId());
    }

    /**
     * Checks if the class supports the UserInterface implementation.
     *
     * @param string $class The user class.
     * @return bool True if supported, false otherwise.
     */
    public function supportsClass(string $class): bool
    {
        return Utilisateur::class === $class || is_subclass_of($class, Utilisateur::class);
    }
}
