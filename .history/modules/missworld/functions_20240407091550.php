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

define('NV_IS_MOD_MISSWORLD', true);

require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

// Đoạn này dùng để chặn người dùng tự ý truy cập vào /detail/
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
    // Phân trang tại trang main hoặc có liên kết tĩnh của danh mục (xem theo danh mục)
    if (isset($array_op[0])) {
        if (preg_match('/^page\-([0-9]+)$/', $array_op[0], $m)) {
            // Phân trang
            $page = intval($m[1]);
        } else {
            // Duyệt danh mục xem liên kết tĩnh nào khớp
            foreach ($global_array_onecat2s as $onecat2) {
                if ($onecat2['alias'] == $array_op[0]) {
                    $catid = $onecat2['id'];
                    break;
                }
            }
            // Không tìm thấy danh mục nào tức liên kết không tồn tại
            if (empty($catid)) {
                nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'], 404);
            }
            // Set $op sang viewcat để xử lý
            $op = 'detail';
        }
    }
}