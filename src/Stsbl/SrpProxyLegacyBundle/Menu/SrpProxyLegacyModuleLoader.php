<?php
// src/Stsbl/SrpProxyLegacyBundle/Menu/SrpProxyLegacyModuleLoader.php
namespace Stsbl\SrpProxyLegacyBundle\Menu;

use IServ\CoreBundle\Menu\AbstractLegacyModuleLoader;
use IServ\CoreBundle\Menu\MenuBuilder;

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
 * Description of SrpProxyLegacyMenuLoader
 *
 * @author Felix Jacobi <felix.jacobi@stsbl.de>
 * @license MIT license <https:/opensoruce.org/licenses/MIT>
 */
class SrpProxyLegacyModuleLoader extends AbstractLegacyModuleLoader 
{
    const PATH = '/usr/share/iserv/www/nav/';

    /**
     * {@inheritdoc}
     */
    public function getPath() {
        return self::PATH;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoute() {
        return 'stsbl_embed_from_legacy';
    }
    
    /**
     * Get list of known legacy modules
     * 
     * @return array
     */
    public static function getKnownLegacyModules() {
        $modules = [];
        
        $modules['srp'] = array(
            'group' => MenuBuilder::GROUP_NETWORK,
            'mod' => '80srp',
            'name' => 'Tfk Schulrouter Plus',
            'uri' => 'srp/index.php',
            'icon' => 'tfk/srp',
            'privileges' => array('srp_link')
        );
        
        return $modules;
    }
}
