<?php

namespace Interview\Donation\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $quoteAddressTable = 'quote_address';
        $quoteTable = 'quote';
        $orderTable = 'sales_order';
        $invoiceTable = 'sales_invoice';

        //Setup two columns for quote, quote_address and order
        //Quote address tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'fee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' =>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Donation Fee'
                ]
            );

        //Quote tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'donation_fee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length'=>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Donation Fee'

                ]
            );

        //Order tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'donation_fee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length'=>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Donation Fee'

                ]
            );

        //Invoice tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'donation_fee',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length'=>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Donation Fee'

                ]
            );

        $setup->endSetup();
    }
}
