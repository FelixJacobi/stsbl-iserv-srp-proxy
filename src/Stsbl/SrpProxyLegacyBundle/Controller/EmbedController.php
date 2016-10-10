<?php
// src/Stsbl/SrpProxyLegacyBundle/Controller/EmbedController.php
namespace Stsbl\SrpProxyLegacyBundle\Controller;

use IServ\CoreBundle\Controller\EmbedController as ParentEmbedController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Stsbl\SrpProxyLegacyBundle\Menu\SrpProxyLegacyModuleLoader;

/**
 * Controller which loading legacy modules in the new IDesk.
 *
 * @author Felix Jacobi <felix.jacobi@stsbl.de>
 * @license http://gnu.org/licenses/gpl-3.0 GNU General Public license
 */
class EmbedController extends ParentEmbedController {
    /**
     * Controls the embedding of legacy pages
     *
     * @param string $name
     * @return Response
     * @Route("/stsbl-legacy/{name}", name="stsbl_embed_from_legacy")
     */
    public function fromLegacyMenuAction($name)
    {
        // We can simply load the module - it's doing the authorization itself
        // TODO: Do at least availability check? Do full auth?
        $module = SrpProxyLegacyModuleLoader::getModule($name);
        $menu = SrpProxyLegacyModuleLoader::convertToItem($module);

        $pageMenu = null;
        if (isset($module['menu'])) {
            $pageMenu = $this->get('iserv.menu.legacy_module_loader')->buildPageMenu($module);
            if (!$pageMenu->hasChildren()) {
                $pageMenu = null;
            }
        }

        return $this->render('IServCoreBundle:Default:embedded.html.twig', ['item' => $menu, 'menu' => $pageMenu]);
    }
}
