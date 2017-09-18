<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\Service;


use Aamant\GedBundle\Entity\Directory;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class Auth
{
    const ROLE_MASK_READ = 'ROLE_GED_ROOT_%d_READ';
    const ROLE_ALL_READ = 'ROLE_GED_ROOT_ALL_READ';
    const ROLE_MASK_WRITE = 'ROLE_GED_ROOT_%d_WRITE';
    const ROLE_ALL_WRITE = 'ROLE_GED_ROOT_ALL_WRITE';

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function isGrantedToRead(Directory $directory)
    {
        if (!$directory->isRoot()){
            $directory = $directory->getRoot();
        }

        $roles = [
            sprintf(self::ROLE_MASK_READ, $directory->getId()),
            self::ROLE_ALL_READ
        ];

        return $this->authorizationChecker->isGranted($roles);
    }

    public function isGrantedToWrite(Directory $directory)
    {
        if (!$directory->isRoot()){
            $directory = $directory->getRoot();
        }

        $roles = [
            sprintf(self::ROLE_MASK_WRITE, $directory->getId()),
            self::ROLE_ALL_WRITE
        ];

        return $this->authorizationChecker->isGranted($roles);
    }
}