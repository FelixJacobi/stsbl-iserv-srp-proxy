<?php
// src/Stsbl/SrpProxyLegacyBundle/StsblSrpProxyLegacyBundle.php
namespace Stsbl\SrpProxyLegacyBundle;

use IServ\CoreBundle\Routing\AutoloadRoutingBundleInterface;
use Stsbl\SrpProxyLegacyBundle\DependencyInjection\StsblSrpProxyLegacyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Felix Jacobi <felix.jacobi@stsbl.de>
 * @license http://gnu.org/licenses/gpl-3.0 GNU General Public License
 */
class StsblSrpProxyLegacyBundle extends Bundle implements AutoloadRoutingBundleInterface
{
    public function getContainerExtension()
    {
        return new StsblSrpProxyLegacyExtension();
    }
}
