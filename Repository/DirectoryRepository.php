<?php

namespace Aamant\GedBundle\Repository;

use Aamant\GedBundle\Entity\Directory;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * DirectoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DirectoryRepository extends NestedTreeRepository
{
    public function createRoot($name = null)
    {
        if (!$name) {
            $name = 'ged_'.uniqid();
        }
        $root = new Directory();
        $root->setTitle($name);

        $this->persistAsFirstChild($root);
        return $root;
    }
}