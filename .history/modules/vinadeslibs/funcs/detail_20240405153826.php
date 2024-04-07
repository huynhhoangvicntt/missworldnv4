<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_LIBS')) {
    exit('Stop!!!');
}


// Các biến cần thiết: Tiêu đề, từ khóa, mô tả
$page_title = $row['title'];
$key_words = $row['keywords'];
$description = $row['description'];

$row = [];

$id = $nv_Request->get_int('id', 'get', 0);
if ($id > 0) {
  $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id=" . $id;
  $result = $db->query($sql);
  if($row = $result->fetch()){
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main');
 }

} else {
  nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main');
}




// Gọi hàm xử lý giao diện
$contents = nv_theme_detail($row, $array_news, $array_olds);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';