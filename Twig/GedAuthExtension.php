<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\Twig;


use Aamant\GedBundle\Entity\Directory;
use Aamant\GedBundle\Service\Auth;
use Twig_SimpleFunction;

class GedAuthExtension extends \Twig_Extension
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app_subscription_extension';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('ged_is_granted_write', [$this, 'write']),
            new Twig_SimpleFunction('ged_is_granted_read', [$this, 'read'])
        ];
    }

    public function write(Directory $directory)
    {
        return $this->auth->isGrantedToWrite($directory);
    }

    public function read(Directory $directory)
    {
        return $this->auth->isGrantedToRead($directory);
    }
}