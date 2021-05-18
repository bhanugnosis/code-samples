<?php

namespace Innovify\Toolinsurance\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Customer\Model\Customer::ENTITY,
                'business_name',
                [
                    'type' => 'varchar',
                    'label' => 'Business name',
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'user_defined' => true,
                    'position' => 999,
                    'system' => 0,
                ]
            );
            $businessName = $this->eavConfig->getAttribute(Customer::ENTITY, 'business_name');

            // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
            $businessName->setData(
                'used_in_forms',
                ['adminhtml_customer']

            );
            $businessName->save();

            $eavSetup->addAttribute(
                \Magento\Customer\Model\Customer::ENTITY,
                'business_desc',
                [
                    'type' => 'varchar',
                    'label' => 'Business description',
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'user_defined' => true,
                    'position' => 999,
                    'system' => 0,
                ]
            );
            $businessDesc = $this->eavConfig->getAttribute(Customer::ENTITY, 'business_desc');

            // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
            $businessDesc->setData(
                'used_in_forms',
                ['adminhtml_customer']

            );
            $businessDesc->save();
        }
    }
}


