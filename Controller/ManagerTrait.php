<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\Controller;


trait ManagerTrait
{
    /**
     * @return \Aamant\GedBundle\Service\Manager
     */
    public function getManager($domain = null)
    {
        return $this->get('aamant_ged.manager');
    }

    /**
     * @return \Knp\Bundle\GaufretteBundle\FilesystemMap|\Gaufrette\Filesystem
     */
    public function getGaufrette($domain = null)
    {
        $map = $this->get('knp_gaufrette.filesystem_map');

        if ($domain){
            return $map->get($domain);
        }

        return $map;
    }
}