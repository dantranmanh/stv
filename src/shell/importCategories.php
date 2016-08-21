<?php
require_once 'abstract.php';

class Mage_Shell_Categories extends Mage_Shell_Abstract
{

    public $_inputFile = '';
    /**
     * @var Root Category information
     */
    public $_rootCategoryName="Default Category";
    public $_rootCategoryId=null;
    /**
     * @var Initting some special list
     */
    public $_nameArray=array();
    public $_csvList=array();

    public $_csvName='categoryCsv.csv';

    /**
     * @var init true or false
     */
    public $_init=true;

    public function run(){

        $init=$this->init();
        if(!$init) {
            $this->showdata('There are something wrong while initting this script.');
            return false;
        }

        $this->showdata('-----------------------------');
        /** create lv2 */
        $this->showdata('creating category level  2 ');
        $lv2 =$this->getCatByLevel(2);
        foreach($this->_csvList as $catString){
            if($catString['level'] != 2 ) continue;
            if (in_array($catString['path'],$this->_lv2)) {
                $this->showdata('This category '.$catString['path'].' has been created before!');
                continue;
            }
            if(!empty($catString['path'])){
                $this->_lv2[]=$catString['path'];
                $this->createNewCategory($catString['name'],$this->_rootCategoryId,$catString['url']);
            }
        }		
        $this->showdata('-----------------------------');
        /*create lv3*/
        $this->showdata('creating category level  3 ');
        $lv3 =$this->getCatByLevel(3);
        foreach($this->_csvList as $catString){
            if($catString['level'] != 3 ) continue;
            if (in_array($catString['path'],$this->_lv3)) {
                $this->showdata('This category '.$catString['path'].' has been created before!');
                continue;
            }
            if(!empty($catString['path'])){
                $this->_lv3[]=$catString['path'];				
                $parentId=$this->getCategoryIdByName($catString['parentname'],$this->getParentPath($catString['path']),null,$catString['parentparent']);
                $this->createNewCategory($catString['name'],$parentId,$catString['url']);
            }
        }
        $this->showdata('-----------------------------');
        /*create lv4*/
        $this->showdata('creating category level  4 ');
        $this->resetMagentoCategoryNameArray();
        $lv4 =$this->getCatByLevel(4);
        foreach($this->_csvList as $catString){
            if($catString['level'] != 4 ) continue;
            if (in_array($catString['path'],$this->_lv4)) {
                $this->showdata('This category '.$catString['path'].' has been created before!');
                continue;
            }
            if(!empty($catString['path'])){
                $this->_lv4[]=$catString['path'];
                $parentId=$this->getCategoryIdByName($catString['parentname'],$this->getParentPath($catString['path']),null,$catString['parentparent']);
                $this->createNewCategory($catString['name'],$parentId,'');
            }
        }

        $this->showdata('-----------------------------');
        /*create lv5*/
        $this->showdata('creating category level  5 ');
        $this->resetMagentoCategoryNameArray();
        $lv5 =$this->getCatByLevel(5);
        foreach($this->_csvList as $catString){
            if($catString['level'] != 5 ) continue;
            if (in_array($catString['path'],$this->_lv5)) {
                $this->showdata('This category '.$catString['path'].' has been created before!');
                continue;
            }
            if(!empty($catString['path'])){
                $this->_lv5[]=$catString['path'];
                $parentId=$this->getCategoryIdByName($catString['parentname'],$this->getParentPath($catString['path']),null,$catString['parentparent']);
                $this->createNewCategory($catString['name'],$parentId,'');
            }
        }
        $this->showdata('-----------------------------');



    }
	public function getParentPath($path=''){
		$arr=explode("|",$path);
		$arr[count($arr)-1]="";
		return implode("|",$arr);		
	}
    public function getImportFilePath(){
        return dirname(__FILE__).DS."data".DS.$this->_csvName;
    }
    public function readCSV(){
        try{
            $file_handle = fopen($this->getImportFilePath(), 'r');
            $i=0;
            $list=array();
            $listPath=array();
            $maxLevel=0;
            while (!feof($file_handle) ) {
               //if($i>=5) break;
                $i++;
                $line = fgetcsv($file_handle, 20480);
                /**
                 * Ignore the header line
                 */
                if(empty($line[0]) || $line[0] == "List Details") continue;
                if (in_array($line[0], $listPath)) continue;
                $listPath[]=$line[0];
                $categoryArray=explode('|',$line[0]);
                if(count($categoryArray) > $maxLevel) $maxLevel = count($categoryArray);
                $parentName=$categoryArray[count($categoryArray)-2];
                $parentparentName=$categoryArray[count($categoryArray)-3];
                $list[]=array('url'=>$line[1],'path'=>$line[0],'name'=>end($categoryArray),'parentname'=>$parentName,'parentparent'=>$parentparentName,'level'=>count($categoryArray));
            }
            $this->showdata('max category level in csv file is : '.$maxLevel);
			$this->log($list,'readcsv.log');
            fclose($file_handle);
        }catch(Exception $e) {
            $this->showdata($e);
            $this->_init =false;
        }
        return $list;
    }
    public function resetMagentoCategoryNameArray(){
        $this->_nameArray=$this->makeMagentoCategoryNameArray(true);
    }
    /**
     * @return bool
     */
    public function init(){
        $this->showInfor();
        /**
         * init Magento category list
         */
        $this->_nameArray=$this->makeMagentoCategoryNameArray();
		//$this->log($this->_nameArray,'name.log');
        $this->showdata('-----------------------------');
        $this->showdata('Root category Name is : '. $this->_rootCategoryName);
        /**
         * set Root Category id
         */
        if(empty($this->_rootCategoryId))
            $this->_rootCategoryId =$this->getRootCategoryIdByName($this->_rootCategoryName);
            $this->showdata('Root category Id is : '. $this->_rootCategoryId);        
        $this->showdata('-----------------------------');
        $this->showdata('Reading csv file');
        $this->_csvList=$this->readCSV();
        return true;
    }
   
    public function getRootCategoryIdByName($name){
        if(empty($name)) return '';
        $category=null;
        $categories=$this->_nameArray[$name];
        foreach($categories as $cat){
            if($cat['level'] == 1 ) $category =$cat;
        }
        if(!empty($category)){
            return $category['id'];
        }else{
            return null;
        }
    }
    public function getCategoryIdByName($name='',$path='',$parentId=null,$parentName=''){
        if(empty($name)) return '';
        $category=null;
        $categories=$this->_nameArray[$name];
        if(count($categories) > 1){            
            foreach($categories as $cat){
				if(!empty($path)){
                    if($cat['idpath'] == $path || $cat['namepath'] == $path){
						$category =$cat;
						break;
					}                        
                }              
                if(!empty($parentId)){
                    if($cat['parentid'] == $parentId){
						$category =$cat;
						break;
					}                        
                }
				if(!empty($parentName)){
                    if($cat['parentname'] == $parentName)
                        $category =$cat;
                }
            }

        }else $category =$categories[0];

        if(!empty($category)){
            return $category['id'];
        }else{
            return null;
        }
    }
    public function makeMagentoCategoryNameArray($refresh=false){
        if(!$refresh) $this->showdata('Making category name list');
        $category = Mage::getModel('catalog/category');
        $tree = $category->getTreeModel();
        $tree->load();
        $ids = $tree->getCollection()->getAllIds();
        $magentoCat=array();
        if ($ids){
            foreach ($ids as $id){
                $cat = Mage::getModel('catalog/category');
                $cat->load($id);
                $name = $cat->getName();
                $path=$this->getCagetoryPathName($cat);
               /* if($refresh){
                    $pathArr=explode('/',$path);
                    if(!in_array($this->_topCategoryNameId,$pathArr)) continue;
                }*/
                $parentCat=Mage::getModel('catalog/category')->load($cat->getParentId());
                $data=array('id'=>$id ,'idpath'=>$cat->getPath(),'namepath'=>$path,'originname'=>$name,'parentid' => $cat->getParentId(),'parentname'=>$parentCat->getName(),'level' => $cat->getLevel());
                $magentoCat[$name][]=$data;
                if(count($magentoCat[$name]) > 1){
                    if(!$refresh) $this->showdata('There are more than '.count($magentoCat[$name]).' categories that have same name : '.$name);
                    if(!$refrest)$this->log($magentoCat[$name],'sameCatName.log');
                }
            }
        }
        if(!$refrest)$this->log($magentoCat,'magentoCatList.log');
        return $magentoCat;
    }
    public function getCatByLevel($level=null){
        if(empty($level)) return array();
        $category = Mage::getModel('catalog/category');
        $tree = $category->getTreeModel();
        $tree->load();
        $ids = $tree->getCollection()->getAllIds();
        $list=array();
        if ($ids){
            foreach ($ids as $id){                
                $cat = Mage::getModel('catalog/category');
                $cat->load($id);
                $name = $cat->getName();
                $nameString='';
                if($cat->getLevel() == $level){
					$namdString=$this->getCagetoryPathName($cat);
                     $list[]=$nameString;
                }
            }
        }
        return $list;
    }

    /**
     * @param string $name
     * @param null $parentId
     * @param string $url
     */
    public function createNewCategory($name="",$parentId=null,$url=""){
        if(empty($parentId)) {
            $this->showdata('Can not create new category '.$name.' without parent Id');
            return false;
        }
        try{
            $name=str_replace("^","/",$name);
            if($this->isCategoryExist($name,$parentId)) {
                $this->showdata('This category '.$name.' has been created before!');
                return;
            }
            if(empty($url)){
                $url=$this->buildUrl($url);
            }
            $category = Mage::getModel('catalog/category');
            $category->setName($name);
            $category->setUrlKey($url);
            $category->setIsActive(1);
            $category->setDisplayMode('PRODUCTS_AND_PAGE');
            $category->setIsAnchor(1); //for active achor
            $parentCategory = Mage::getModel('catalog/category')->load($parentId);
            $category->setPath($parentCategory->getPath());
            $category->save();
            $this->showdata('Created category name = '.$name.' parentid = : '.$parentId);
        } catch(Exception $e) {
            var_dump($e);
        }

    }
    public function buildUrl($string){
        $string=str_replace("\/", "",$string);
        $string=str_replace("  ", " ",$string);
        $string=str_replace("&", "",$string);
        $string=str_replace(":", "",$string);
        $string=str_replace("+", "",$string);
        $string=str_replace(" ", "-",$string);
        $string=strtolower($string);
        $string="tromvia-".$string;
        return $string;
    }
    /**
     * @param string $name
     * @param int $parentid
     * @return bool
     */
    public function isCategoryExist($name ='',$parentid=0){
        if(empty($parentid)) return false;
        $category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $name);
        foreach($category as $cat){
            if($parentid == $cat->getData('parent_id')) return true;
        }
        return false;
    }
    public function showInfor(){
        $this->showdata('Max level of created categories is NaN');
        $this->showdata('        ');
        $this->showdata('-----------------------------');
        $this->showdata('        ');
    }
	public function getCagetoryPathName($cat = null){
		if(!$cat) return false;
		$path=explode("/",$cat->getPath());
		$string="";$i=0;
		foreach($path as $id){
			$category = Mage::getModel('catalog/category')->load($id);
			if($i==0)
            $string=$category->getName();
			else
				$string=$string."|".$category->getName(); 
			$i++;
		}
		return $string;
	}
   /**
 * @param $string
 * @return string
 */
    function proccessString($string){
        $string=str_replace("\/", "",$string);
        $string=str_replace(" ", "",$string);
        $string=str_replace("  ", "",$string);
        $string=str_replace("&", "",$string);
        $string=strtolower($string);
        return $string;
    }

    /**
     * @param $data
     * @param $filename
     */
    public  function log($data,$filename){
        Mage::log($data, Zend_Log::DEBUG, $filename);
        $this->showdata(' Please view var/log/'.$filename.' for more details.');
        return;
    }
    public  function showdata($data){
        echo $data."\n";

    }
    function cutSpace($string=''){
        return str_replace(" ","",$string);
    }
}

$shell = new Mage_Shell_Categories();
$shell->run();