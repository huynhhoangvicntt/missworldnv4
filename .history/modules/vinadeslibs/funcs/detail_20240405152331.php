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

die($id. 'sss');

// Các biến cần thiết: Tiêu đề, từ khóa, mô tả
$page_title = $row['title'];
$key_words = $row['keywords'];
$description = $row['description'];

$row = [];

//---------------------
//Viet code o day
//--------------------




// Gọi hàm xử lý giao diện
$contents = nv_theme_detail($row, $array_news, $array_olds);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';