<?php
require_once 'abstract.php';

/**
 *
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Shell_Compiler extends Mage_Shell_Abstract
{

    /***
     *
     * NEED TO BE TESTED CAREFULLY BEFORE RUNNING SCRIPT ON SITE.
     *
     */

    const newsite_website_code='base';
    const newsite_website_name='Main Website';
    const newsite_store_name='English';
    const newsite_store_code='default';
    const newsite_group_name='Madison Island';


    /* init private setting for new webstie**/

    const base_url="http://www.sydneyoperahouseshop.com/";
    const secure_url="https://www.sydneyoperahouseshop.com/";
    const package ="rwd";
    const locale ="sydney";
    const template ="sydney";
    const skin ="sydney";
    const layout ="sydney";
    const themedefault ="default";

    const configdata=array(
        "design/header/logo_src"	=>	"images/logo.png"	,
        "design/header/logo_alt"	=>	"Sydney Opera House"	,
        "design/header/logo_src_small"	=>	"images/logo.png"	,
        "design/header/welcome"	=>		"Sydney Opera House Shop",
        "design/footer/copyright"	=>	"&copy; 2016  Newslink Pty Ltd. All Rights Reserved."	,
        "design/head/title_prefix"	=>	null	,
        "design/head/title_suffix"	=>	null	,
        "design/head/default_description"	=>	null	,
        "design/head/default_keywords"	=>	null	,
        "design/head/default_robots"	=>	"NOINDEX,NOFOLLOW"	,
        "design/head/includes"	=>	null	,
        "design/email/logo"	=>	null	,
        "design/email/logo_alt"	=>	"Sydney Opera House"	,

        "tax/classes/shipping_tax_class"=> 0,
        "tax/classes/wrapping_tax_class"	=> 0 ,
        "tax/classes/surcharge_tax_class"	=> 0 ,
        "tax/calculation/algorithm"	=> "TOTAL_BASE_CALCULATION" ,
        "tax/calculation/based_on"	=> "origin" ,
        "tax/calculation/price_includes_tax"	=>  1,
        "tax/calculation/shipping_includes_tax"	=> 1 ,
        "tax/calculation/tax_included_in_surcharge"	=> 1 ,
        "tax/calculation/apply_after_discount"	=> 1 ,
        "tax/calculation/discount_tax"	=>  1,
        "tax/calculation/apply_tax_on"	=> 0 ,
        "tax/calculation/cross_border_trade_enabled"	=> 0 ,
        "tax/defaults/country"	=>  "AU",
        "tax/defaults/region"	=>  0,
        "tax/defaults/postcode"	=>  "*",
        "tax/display/type"	=>  2,
        "tax/display/shipping"	=>  2,
        "tax/cart_display/price"	=> 2 ,
        "tax/cart_display/subtotal"	=> 2 ,
        "tax/cart_display/shipping"	=> 2 ,
        "tax/cart_display/surcharge"	=> 2 ,
        "tax/cart_display/gift_wrapping"	=> 2  ,
        "tax/cart_display/printed_card"	=> 2 ,
        "tax/cart_display/grandtotal"	=>  0,
        "tax/cart_display/full_summary"	=>  0,
        "tax/cart_display/zero_tax"	=> 0 ,
        "tax/sales_display/price"	=> 1 ,
        "tax/sales_display/subtotal"	=> 1 ,
        "tax/sales_display/shipping"	=> 1 ,
        "tax/sales_display/surcharge"	=>  1,
        "tax/sales_display/gift_wrapping"	=> 1 ,
        "tax/sales_display/printed_card"	=> 1 ,
        "tax/sales_display/grandtotal"	=> 0 ,
        "tax/sales_display/full_summary"	=> 0 ,
        "tax/sales_display/zero_tax"	=>  0,
        "tax/weee/enable"	=> 0 ,
        "tax/weee/display_list"	=> 0 ,
        "tax/weee/display"	=> 0 ,
        "tax/weee/display_sales"	=> 0 ,
        "tax/weee/display_email"	=> 0 ,
        "tax/weee/discount"	=> 0 ,
        "tax/weee/apply_vat"	=> 0 ,
        "tax/weee/include_in_subtotal"	=> 0 ,
        "shipping/origin/country_id"	=> "AU"  ,
        "shipping/origin/region_id"	=> 488 ,
        "shipping/origin/postcode"	=> null ,
        "payment/verisign/active"	 => 0 ,
        "paypal/general/business_account"	=> 'nz_seller_sandbox@gmail.com' ,
        "payment/paypal_standard/active"	=> 0 ,
        "payment/paypal_standard/payment_action"	=> "Sale"  ,
        "payment/paypal_standard/sandbox_flag"	=> 1 ,
        "payment/paypal_standard/verify_peer"	=> 0 ,
        "paypal/wpp/api_username"	=>  '0:2:120fd9f4367b6b62:L1oZN7kX1YNC7u1OiDjKOn6eo9Nd/5ZDAzlVB8ZS8OA=',
        "paypal/wpp/api_password"	=>  '0:2:87c09b0007472fda:Ivo1gWcUqPXOE9mXWOG8Vg==',
        "paypal/wpp/api_signature"	=>  '0:2:7af5690e4cdfa16c:UZeTbghtpmScNoMdVOyCe27T7KUxLhzu1jdVIxvZkICc5zRHEBi7EB6YHfmA/4Bdybl0XrSJndlwOmfMPp3Uzw==',
        "paypal/wpp/sandbox_flag"	=>  1,
        "payment/paypal_express/active"	=>  1,
        "payment/paypal_express_bml/active"	=>  0,
        "payment/paypal_express/payment_action"	=> 'Sale' ,
        "payment/paypal_express/verify_peer"	=> 0 ,
        "payment/pbridge/profilestatus"	=> 0 ,
        "carriers/tablerate/import"	=> 1462953465 ,
        "carriers/eparcel/active"	=> 0 ,
        "carriers/eparcel/import"	=>  1462953465 ,
        "carriers/australiapost/active"	=> 1 ,
        "carriers/australiapost/developer_mode"	=>  1,
        "carriers/australiapost/api_key"	=> '0:2:3118d6ecb232c45d:NfnnVfPYoiPIw/gwoEqBqNydjfrryZYVOjKzpqo2xZM=' ,
        "carriers/australiapost/allowed_methods"	=> 'INTL_SERVICE_AIR_MAIL,AUS_PARCEL_COURIER,AUS_PARCEL_COURIER_SATCHEL_MEDIUM,INTL_SERVICE_ECI_D,INTL_SERVICE_ECI_M,INTL_SERVICE_ECI_PLATINUM,AUS_PARCEL_EXPRESS,INTL_SERVICE_EPI,INTL_SERVICE_EPI_B4,INTL_SERVICE_EPI_C5,AUS_LETTER_EXPRESS_SMALL,AUS_LETTER_REGULAR_LARGE,INTL_SERVICE_PTI,AUS_PARCEL_REGULAR,INTL_SERVICE_RPI,INTL_SERVICE_RPI_B4,INTL_SERVICE_RPI_DLE,INTL_SERVICE_SEA_MAIL' ,
        "dev/debug/template_hints"	=>  0,
        "dev/debug/template_hints_blocks"	=> 0 ,
        "web/default/cms_no_route"	=>  'no-route|44',
        "google/recaptcha/enabled"	=>  1,
        "google/recaptcha/enabled_customer_registration"	=> 1 ,
        "google/recaptcha/site_key"	=>  '6LcAvR0TAAAAADmE-IP2k7TPn3lh6gig28RHveKf',
        "google/recaptcha/secret_key"	=>  '6LcAvR0TAAAAAMyrHJevd1kJckZzx4XnoLtGZnfj',
        "payment/paypal_express/solution_type"	=> 'Sole' ,
        "payment/paypal_express/skip_order_review_step"	=> 0 ,
        "paypal/general/merchant_country"	=>  'NZ',
        "web/secure/use_in_frontend"	=> 0 ,
        "po_passwordmeter/general/is_enabled"	=> 1 ,
        "rewards/display/showSidebar"	=> 0 ,
        "rewards/display/sendInvitationEmailToUnregisteredFriend"	=> 1 ,
        "rewards/display/showMiniRedeemCatalog"	=> 0 ,
        "rewards/display/showPointsOptimizer"	=>  0,
        "rewards/display/showEarningGraphic"	=> 0 ,
        "rewards/autointegration/header_points_balance"	=> 0 ,
        "rewards/autointegration/shopping_cart_item_points"	=> 0 ,
        "rewards/autointegration/shopping_cart_under_coupon"	=> 0 ,
        "rewards/autointegration/customer_dashboard_summary"	=> 0 ,
        "rewards/autointegration/customer_register_referral_field"	=>  0,
        "rewards/autointegration/onepage_billing_register_referral_field"	=> 0 ,
        "advanced/modules_disable_output/TBT_Rewards"	=> 1 ,
        "advanced/modules_disable_output/TBT_RewardsApi"	=>  1,
        "advanced/modules_disable_output/TBT_RewardsCoreCustomer"	=> 1 ,
        "advanced/modules_disable_output/TBT_RewardsCoreSpending"	=> 1 ,
        "advanced/modules_disable_output/TBT_RewardsLoyalty"	=>  1,
        "advanced/modules_disable_output/TBT_RewardsOnly"	=> 1 ,
        "advanced/modules_disable_output/TBT_RewardsPlat"	=> 1 ,
        "advanced/modules_disable_output/TBT_RewardsReferral"	=> 1 ,
        "advanced/modules_disable_output/TBT_Rewardssocial"	=> 1 ,
        "advanced/modules_disable_output/TBT_Testsweet"	=> 1 ,
        "rewards/general/layoutsactive"	=> 0 ,
        "design/head/shortcut_icon"	=> 'websites/5/favicon.ico' ,
        "payment/ccsave/active"	=> 1 ,
        "carriers/australiapost/signature_on_delivery"	=> 2 ,
        "carriers/flatrate/active"	=> 0 ,
        "sales_email/order/template"	=> 'sales_email_order_template' ,
        "sales_email/order/guest_template"	=> 'sales_email_order_guest_template' ,
        "sales_email/shipment/template"	=>  'sales_email_shipment_template',
        "web/cookie/cookie_path"	=>  null ,
        /*"web/cookie/cookie_domain"	=> null,*/
        "featuredproduct/general/show_product_number"	=> 8 ,
        "featuredproduct/general/show_type"	=> 'slider' ,
        "ajaxcartpro/addproductconfirmation/content"	=>  ' <div class="ajax-popup-close">
                                <img src="{{skin url="images/ajax-popup-close-icon.png"}}"  id="ajax-popup-close"/>
                                </div>
                                <p>
                                <b>{{var product.name}}</b>
                                <br/>
                                was added to your shopping cart
                                </p>
                                <div class="popup-actions">
                                {{block type="ajaxcartpro/confirmation_items_gotocheckout"}}
                                {{block type="ajaxcartpro/confirmation_items_continue"}}
                                </div>'
    );


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
        $this->processSOH();
    }
    public function processSOH(){
        $website_code= $this->getNewWebsiteCode();
        $website_name=$this->getNewWebsiteName();
        $store_name=$this->getNewWebsiteStoreName();
        $store_code=$this->getNewWebsiteStoreCode();
        $group_name=$this->getNewWebsiteGroupName();


        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
// Load the website
        $website = Mage::getModel('core/website')->load($website_code, 'code');
        $root_id=null;
        foreach (Mage::app()->getWebsites() as $_website) {
            if ($_website->getIsDefault()) {
                $root_id=$_website->getDefaultStore()->getRootCategoryId();
            }
        }
        $websiteId=$website->getId();
        if($website->getId() > 0) {
            echo "Website already exists\n";
            echo "Updating store-group\n";
            $group = Mage::getModel('core/store_group')->load($website->getId(), 'website_id');
            $group->setData('root_category_id', $root_id);
            $group->save();

        }else{
            // Create the website
            echo "Creating new website\n";
            $website->setData('name', ucfirst($website_name).' Website');
            $website->setData('code', $website_code);
            $website->setData('sort_order', 1);
            $website->setData('is_default', 0);
            $website->save();
            $websiteId = $website->getWebsiteId();
        }


        // Create the group

        echo "Creating new store-group\n";
        $group = Mage::getModel('core/store_group')->load($websiteId, 'website_id');
        $group->setData('website_id', $websiteId);
        $group->setData('name', ucfirst($group_name).' Store');
        $group->setData('root_category_id', $root_id);
        $group->save();
        $groupId = $group->getGroupId();


        // Create the store

        echo "Creating new store\n";
        //$store = Mage::getModel('core/store');
        $store =  Mage::getModel('core/store')->load($store_code, 'code');
        if($store->getId() >0 ){
            echo "Store view already exists\n";
        }else{
            $store->setData('website_id', $websiteId);
            $store->setData('group_id', $groupId);
            $store->setData('name', ucfirst($store_name).' Store');
            $store->setData('code', $store_code);
            $store->setData('is_active', 1);
            $store->save();
            $storeId = $store->getStoreId();
        }

        // Update the website
        echo "Updating website\n";
        $website->setData('default_group_id', $groupId);
        $website->save();

        // Update the group
        echo "Updating store-group\n";
        $group->setData('default_store_id', $storeId);
        $group->save();
        //setup base url

        $base_url="http://www.sydneyoperahouseshop.com/";
        $secure_url="https://www.sydneyoperahouseshop.com/";
        Mage::getConfig()->saveConfig('web/unsecure/base_url',$base_url,'websites',$websiteId);
        Mage::getConfig()->saveConfig('web/secure/base_url',$secure_url,'websites',$websiteId);

        Mage::getConfig()->saveConfig('design/package/name',self::package,'websites',$websiteId);
        $this->showdata("Updated/created the setting for package");
        Mage::getConfig()->saveConfig('design/theme/locale',self::locale,'websites',$websiteId);
        $this->showdata("Updated/created the setting for locale");
        Mage::getConfig()->saveConfig('design/theme/template',self::template,'websites',$websiteId);
        $this->showdata("Updated/created the setting for template");
        Mage::getConfig()->saveConfig('design/theme/skin',self::skin,'websites',$websiteId);
        $this->showdata("Updated/created the setting for skin");
        Mage::getConfig()->saveConfig('design/theme/layout',self::layout,'websites',$websiteId);
        $this->showdata("Updated/created the setting for layout");
        Mage::getConfig()->saveConfig('design/theme/default',self::themedefault,'websites',$websiteId);

        foreach(self::configdata as $configPath => $configValue){
            Mage::getConfig()->saveConfig($configPath ,$configValue,'websites',$websiteId);
            $this->showdata("Updated/created the setting for config : ".$configPath);
        }

        $this->showdata(" ");
        $this->showdata(" ");
        $this->showdata(" ");
        $this->showdata("Finished Updating/creating  the setting for  new store: ".self::newsite_website_name);
    }
}

$shell = new Mage_Shell_Compiler();
$shell->run();
