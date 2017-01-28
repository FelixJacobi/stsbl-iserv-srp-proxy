<?php
// src/Stsbl/SrpProxyLegacyBundle/Controller/EmbedController.php
namespace Stsbl\SrpProxyLegacyBundle\Controller;

use IServ\CoreBundle\Controller\EmbedController as BaseEmbedController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Stsbl\SrpProxyLegacyBundle\Menu\SrpProxyLegacyModuleLoader;

/*
 * The MIT License
 *
 * Copyright 2017 Felix Jacobi.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Controller which loading legacy modules in the new IDesk.
 *
 * @author Felix Jacobi <felix.jacobi@stsbl.de>
 * @license MIT license <https:/opensoruce.org/licenses/MIT>
 */
class EmbedController extends BaseEmbedController 
{
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
