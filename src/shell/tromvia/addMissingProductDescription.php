<?php
require_once '../abstract.php';

/**
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Shell_Compiler extends Mage_Shell_Abstract
{
    public  function showdata($data){
        var_dump($data);
        echo '\n';
    }
    public function run()
    {
		$collection = Mage::getModel('catalog/product')->getCollection();
        echo get_class($collection);

			$this->showdata('there are '.count($collection).' product');
			$i=0;
            foreach ($collection as $product) {
                $product=Mage::getModel('catalog/product')->load($product->getEntityId());
                 $description=$product->getDescription();
                 $shortDescription=$product->getShortDescription();
                 $j=0;
                 if(empty($description)){
                    $product->setDescription($product->getName());
                     $this->showdata('updated Description for : '.$product->getName());
                     $i++;
                     $j++;
                 }
                 if(empty($shortDescription)){
                     $this->showdata('updated Short Description for : '.$product->getName());
                     if($j == 0) $i++;
                 }

                $this->showdata('updated description/short description for : '.$i.' products');
            }
    }
}

$shell = new Mage_Shell_Compiler();
$shell->run();
