<?php
declare(strict_types=1);

namespace Saleswarp\SaleswarpShip\Setup\Patch\Data;

use Magento\Integration\Model\ConfigBasedIntegrationManager;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

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
	 * @var ModuleDataSetupInterface
	 */
	 private $moduleDataSetup;

	/**
	 * @var EavSetupFactory
	 */
	 private $eavSetupFactory;

    /**
     * @param ConfigBasedIntegrationManager $integrationManager
     */
    public function __construct(
    	ConfigBasedIntegrationManager $integrationManager,
    	ModuleDataSetupInterface $moduleDataSetup,
    	EavSetupFactory $eavSetupFactory
	)
    {
        $this->integrationManager = $integrationManager;
        $this->moduleDataSetup    = $moduleDataSetup;
        $this->eavSetupFactory    = $eavSetupFactory;
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
		$this->moduleDataSetup->getConnection()->startSetup();

		$eavSetup = $this->eavSetupFactory->create([‘setup’ => $this->moduleDataSetup]);

        $eavSetup->delete('patch_list', ['patch_name = ?' => '%SaleswarpShip%']);
        $eavSetup->delete('integration', ['name = ?' => '%SaleswarpShip%']);

		$this->moduleDataSetup->getConnection()->endSetup();
	}
}
