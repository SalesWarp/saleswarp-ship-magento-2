<?php
declare(strict_types=1);

namespace Saleswarp\SaleswarpShipDev\Setup\Patch\Data;

use Magento\Integration\Model\ConfigBasedIntegrationManager;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Setup data patch class to change config path
 */
class PatchData implements DataPatchInterface
{

    /**
     * @var ConfigBasedIntegrationManager
     */
     private $integrationManager;

    /**
     * @param ConfigBasedIntegrationManager $integrationManager
     */
    public function __construct(ConfigBasedIntegrationManager $integrationManager)
    {
        $this->integrationManager = $integrationManager;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->integrationManager->processIntegrationConfig(['SaleswarpShipDev']);
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
