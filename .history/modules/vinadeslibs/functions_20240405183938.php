<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
}

define('NV_IS_MOD_LIBS', true);

require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

// Đoạn này dùng để chặn người dùng tự ý truy cập vào /viewcat/ hoặc /detail/
if (in_array($op, ['detail'])) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'], 404);
}

// Tạo biến này nếu xem theo danh mục
$catid = 0;

// Các biến sử dụng phân trang
$page = 1;
$per_page = 10;
$per_page_detail = 6;

// Xử lý điều khiển các op
if ($op == 'main') {
    // Phân trang tại trang cat hoặc có liên kết tĩnh của bài viết (xem chi tiết bài viết)
    if (isset($array_op[1])) {
        if (preg_match('/^page\-([0-9]+)$/', $array_op[1], $m)) {
            // Phân trang
            $page = intval($m[1]);
        } else {
            // Set $op sang detail để xử lý
            $op = 'detail';
        }
    }
}