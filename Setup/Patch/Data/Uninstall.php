<?php
declare(strict_types=1);

namespace Saleswarp\SaleswarpShipDev\Setup\Patch\Data;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Db\Select;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface as UninstallInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
/**
 * Class Uninstall
 */
class Uninstall implements DataPatchInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;
    
    private $_mDSetup;
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $mDSetup,
        SchemaSetupInterface $setup
    )
    {
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_mDSetup         = $mDSetup;
        $this->setup            = $setup;
    }

    public function apply()
    {
        $setup     = $this->setup;
        $installer = $setup;

        $installer->startSetup();

        /** @var AdapterInterface $connection */
        $connection = $installer->getConnection();
        $connection->delete($setup->getTable('patch_list'), ['patch_name = ?' => 'Saleswarp\SaleswarpShipDev%']);
        $connection->delete($setup->getTable('integration'), ['name = ?' => 'SaleswarpShipDev%']);

		$connection->query("DELETE FROM `patch_list` WHERE `patch_list`.`patch_name` LIKE 'Saleswarp\SaleswarpShipDev%'");

        $installer->endSetup();
    }

    /**
    * Get Dependecies
    */
     public static function getDependencies()
     {
        return [];
     }

     /**
     * Get Aliases
     */
      public function getAliases()
      {
         return [];
      }
}
