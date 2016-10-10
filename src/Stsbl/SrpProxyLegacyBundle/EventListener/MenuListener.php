<?php
// src/Stsbl/SrpProxyLegacyBundle/EventListener/MenuListener.php
namespace Stsbl\SrpProxyLegacyBundle\EventListener;

use IServ\CoreBundle\Event\MenuEvent;
use IServ\CoreBundle\EventListener\MainMenuListenerInterface;
use Stsbl\SrpProxyLegacyBundle\Menu\SrpProxyLegacyModuleLoader;

/**
 * @author Felix Jacobi <felix.jacobi@stsbl.de>
 * @license http://gnu.org/licenses/gpl-3.0 GNU General Public License 
 */

class MenuListener implements MainMenuListenerInterface {
    /**
     * @var SrpProxyLegacyModuleLoader
     */
    private $legacyModuleLoader;
    
    /**
     * Injects the legacy module loader into the class
     * 
     * @param SrpProxyLegacyModuleLoader $legacyModuleLoader
     */
    public function setLegacyModuleLoader(SrpProxyLegacyModuleLoader $legacyModuleLoader)
    {
        $this->legacyModuleLoader = $legacyModuleLoader;
    }
    
    /**
     * @param \IServ\CoreBundle\Event\MenuEvent $event
     */
    public function onBuildMainMenu(MenuEvent $event)
    {
        $menu = $event->getMenu();
        $this->legacyModuleLoader->injectModulesIntoMenu($menu);
    }
}
