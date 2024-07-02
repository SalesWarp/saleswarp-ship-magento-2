<?php
declare(strict_types=1);

namespace Saleswarp\SaleswarpShip\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Integration\Model\ConfigBasedIntegrationManager;

/**
 * Setup data patch class to change config path
 */
class PatchData implements DataPatchInterface, PatchRevertableInterface
{

    /**
     * @var ConfigBasedIntegrationManager
     */
     private $integrationManager;

    /**
     * @var ModuleDataSetupInterface
     */
     private $moduleDataSetup;

    /**
     * @param ConfigBasedIntegrationManager $integrationManager
     * @param ModuleDataSetupInterface      $moduleDataSetup
     */
    public function __construct(
        ConfigBasedIntegrationManager $integrationManager,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->integrationManager = $integrationManager;
        $this->moduleDataSetup    = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->integrationManager->processIntegrationConfig(['SaleswarpShip']);
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
        return '1.0.1';
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        $patchListTable = $this->moduleDataSetup->getTable('patch_list');
        $this->moduleDataSetup->getConnection()->delete($patchListTable, ['patch_name = ?' => '%\SaleswarpShip\%']);

        $integrationTable = $this->moduleDataSetup->getTable('integration');
        $this->moduleDataSetup->getConnection()->delete($integrationTable, ['name = ?' => 'SaleswarpShip']);
    }
}
