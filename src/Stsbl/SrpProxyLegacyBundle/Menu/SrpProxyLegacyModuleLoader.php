<?php
// src/Stsbl/SrpProxyLegacyBundle/Menu/SrpProxyLegacyModuleLoader.php
namespace Stsbl\SrpProxyLegacyBundle\Menu;

use IServ\CoreBundle\Menu\AbstractLegacyModuleLoader;
use IServ\CoreBundle\Menu\MenuBuilder;

/**
 * Description of SrpProxyLegacyMenuLoader
 *
 * @author Felix Jacobi <felix.jacobi@stsbl.de>
 * @license http://gnu.org/licenses/gpl-3.0 GNU General Public License
 */
class SrpProxyLegacyModuleLoader extends AbstractLegacyModuleLoader {
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
