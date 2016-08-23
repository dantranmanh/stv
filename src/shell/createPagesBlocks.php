<?php
require_once 'abstract.php';

/**
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Shell_Compiler extends Mage_Shell_Abstract
{

    const newsite_website_code='base';
    const newsite_website_name='Main Website';
    const newsite_store_name='English';
    const newsite_store_code='default';
    const newsite_group_name='Madision Island';

    public function getNewWebsiteCode(){
        return self::newsite_website_code;
    }

    public function getNewWebsiteName(){
        return self::newsite_website_name;
    }

    public function getNewWebsiteStoreName(){
        return self::newsite_store_name;
    }

    public function getNewWebsiteStoreCode(){
        return self::newsite_store_code;
    }

    public function getNewWebsiteGroupName(){
        return self::newsite_group_name;
    }

    public  function showdata($data){
        echo $data."\n";
    }
    public function run()
    {
        error_reporting(E_ALL | E_STRICT);
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

        $this->processCmsBlocks();
        $this->processCmsPages();
    }
    public function processCmsBlocks(){
        $store_code=$this->getNewWebsiteStoreCode();
        $enStore = Mage::app()->getStore($store_code);
        // For creating a block for a store
        $array_cms_block = array (
            'left_info_block'=>array('title'=>'left_info_block', 'stores'=> array($enStore->getId())),
            'right_info_block'=>array('title'=>'right_info_block', 'stores'=> array($enStore->getId())),
            'footer_links'=>array('title'=>'footer_links', 'stores'=> array($enStore->getId())),
            'home_page_header_block'=>array('title'=>'home_page_header_block', 'stores'=> array($enStore->getId()))
        );
        foreach($array_cms_block as $cms_block => $cms_block_info) {
            $blockData = array (
                'identifier' => $cms_block,
                'title' => $cms_block_info['title'],
                'root_template' => 'one_column',
                'stores' => $cms_block_info['stores'],
                'content' => file_get_contents(__DIR__ .DS.'cms_block'.DS.'0.1.0'.DS.$cms_block.'.html')
            );
            $cmsBlocks = Mage::getModel('cms/block')->getCollection()
                ->addFieldToFilter('identifier',array('eq'=>$blockData['identifier']));

            $newBlock=null;
            foreach($cmsBlocks as $block){
                $block=Mage::getModel('cms/block')->load($block->getBlockId());
                if(in_array($enStore->getId(),$block->getStoreId())) {
                    $newBlock = $block;
                }
            }
            if(!empty($newBlock)){
                $newBlock->addData($blockData)->save();
            }else
                Mage::getModel('cms/block')->setData($blockData)->save();
            $this->showdata("created/updated the cms block: ".$blockData['title']);
        }
    }
    public function processCmsPages(){
        $store_code=$this->getNewWebsiteStoreCode();
        $enStore = Mage::app()->getStore($store_code);
        //$enStore = Mage::app()->getStore("auckland");
        // For creating a block for a store
        $array_cms_page = array (
            'trom-via'=>
            array('title'=>'Trộm Vía Shop - Thời trang trẻ em', 'stores'=> array($enStore->getId()))
        );
        foreach($array_cms_page as $cms_page => $cms_page_info) {
            $pageData = array (
                'identifier' => $cms_page,
                'title' => $cms_page_info['title'],
                'root_template' => 'three_column',
                'stores' => $cms_page_info['stores'],
                'content' => file_get_contents(__DIR__ .DS.'cms_page'.DS.'0.1.0'.DS.$cms_page.'.html')
            );
            $cmsPages = Mage::getModel('cms/page')->getCollection()
                ->addFieldToFilter('identifier',array('eq'=>$pageData['identifier']));
            $newPage=null;
            foreach($cmsPages as $page){
                $page=Mage::getModel('cms/page')->load($page->getPageId());
                if(in_array($enStore->getId(),$page->getStoreId())) $newPage = $page;
            }
            if(!empty($newPage)){
                $newPage->addData($pageData)->save();
            }else
                Mage::getModel('cms/page')->setData($pageData)->save();
            $this->showdata("created/updated the cms page: ".$pageData['title']);

        }
    }
}


$shell = new Mage_Shell_Compiler();
$shell->run();
