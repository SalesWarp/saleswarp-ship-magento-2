<?php

namespace Saleswarp\SaleswarpShip\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        $connection->delete($setup->getTable('patch_list'), ['patch_name = ?' => '%Saleswarp\SaleswarpShip%']);
        $connection->delete($setup->getTable('integration'), ['name = ?' => '%SaleswarpShip%']);

        $setup->endSetup();
    }
}
