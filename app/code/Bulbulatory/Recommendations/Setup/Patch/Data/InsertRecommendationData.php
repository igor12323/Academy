<?php

namespace Bulbulatory\Recommendations\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InsertRecommendationData implements DataPatchInterface
{
        
    private $moduleDataSetup;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $setup = $this->moduleDataSetup;

        $data = [
            ['customer_id' => 3, 'email_address'=>'test1@test.com','hash'=>'DC40A33217FC1D173122CEECFD121F438D691DC29015D837BF48015B30B764FA'],
            ['customer_id' => 2, 'email_address'=>'test2@test.com','hash'=>'A9EAC99E13F1029137B2A2AE02C7254891489F88DA1ECDF517A09E7C3371A047'],
            ['customer_id' => 2, 'email_address'=>'test3a@test.com','hash'=>'50E37FC78CD9E9422717ECA9F2B96FD020085B3A41379AFA46FC085F2CCF8E7E']
        ];
        $setup->getConnection()->insertArray(
            $setup->getTable('recommendation'),
            ['customer_id', 'email_address','hash'],
            $data
        );
       
        $this->moduleDataSetup->endSetup();
    }
}