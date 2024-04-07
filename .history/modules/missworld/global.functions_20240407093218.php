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



// Danh mục đa cấp. Ngoài site chỉ lấy status=1 admin lấy hết
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s " . (defined('NV_ADMIN') ? '' : ' WHERE status=1') . " ORDER BY weight ASC";
$global_array_onecat2s = $nv_Cache->db($sql, 'id', $module_name);