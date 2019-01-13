<?php
/**
 * also_purchased_products.php
 * 
 * zca_diy_tpl 1.0.0 
 *
 * @package modules
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version ZCA/GIT: $Id: rbarbour (zcadditions.com) New for v1.5.6 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

if ( $detect->isMobile() && !$detect->isTablet() && $_SESSION['layoutType'] == 'full' || $detect->isTablet() && $_SESSION['layoutType'] == 'full' || $_SESSION['layoutType'] == 'full' ){
$col_per_row = SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS;
} else if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) {
$col_per_row = SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS_MOBILE;
} else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet'){
$col_per_row = SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS_TABLET;
} else {
$col_per_row = SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS;
}

if (isset($_GET['products_id']) && $col_per_row > 0 && MIN_DISPLAY_ALSO_PURCHASED > 0) {

  $also_purchased_products = $db->ExecuteRandomMulti(sprintf(SQL_ALSO_PURCHASED, (int)$_GET['products_id'], (int)$_GET['products_id']), MAX_DISPLAY_ALSO_PURCHASED);

  $num_products_ordered = $also_purchased_products->RecordCount();

  $row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';

  // show only when 1 or more and equal to or greater than minimum set in admin
  if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED && $num_products_ordered > 0) {
    if ($num_products_ordered < $col_per_row) {
      $col_width = floor(100/$num_products_ordered);
    } else {
      $col_width = floor(100/$col_per_row);
    }

    while (!$also_purchased_products->EOF) {
      $also_purchased_products->fields['products_name'] = zen_get_products_name($also_purchased_products->fields['products_id']);
//-bof-zca_diy_tpl_demo  *** 1 of 0 ***
//      $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsAlsoPurch"' . ' ' . 'style="width:' . $col_width . '%;"',
      $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsAlsoPurch centeredContent columns' . $col_per_row . '"',
//-eof-zca_diy_tpl_demo  *** 1 of 0 ***
      'text' => (($also_purchased_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $also_purchased_products->fields['products_image'], $also_purchased_products->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br />') . '<a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '">' . $also_purchased_products->fields['products_name'] . '</a>');

      $col ++;
      if ($col > ($col_per_row - 1)) {
        $col = 0;
        $row ++;
      }
      $also_purchased_products->MoveNextRandom();
    }
  }
  if ($also_purchased_products->RecordCount() > 0 && $also_purchased_products->RecordCount() >= MIN_DISPLAY_ALSO_PURCHASED) {
    $title = '<h2 class="centerBoxHeading">' . TEXT_ALSO_PURCHASED_PRODUCTS . '</h2>';
    $zc_show_also_purchased = true;
  }
}
