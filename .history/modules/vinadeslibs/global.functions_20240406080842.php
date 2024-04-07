<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

/**
 * BEGIN code global danh mục đa cấp
 */

// Danh mục đa cấp. Ngoài site chỉ lấy status=1 admin lấy hết
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s " . (defined('NV_ADMIN') ? '' : ' WHERE status=1') . " ORDER BY sort ASC";
$global_array_cats = $nv_Cache->db($sql, 'id', $module_name);

/**
 * @param integer $id
 * @return array
 * @desc Hàm lấy mảng chứa danh sách id danh mục con của 1 danh mục nào đó, tính cả danh mục đó
 */

/**
 * END code global danh mục đa cấp
 */

/**
 * BEGIN code danh mục một cấp dạng 1
 */
// Danh mục
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s ORDER BY weight ASC";
$global_array_onecat2s = $nv_Cache->db($sql, 'id', $module_name);

/**
 * END code danh mục một cấp dạng 1
 */