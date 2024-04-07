<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

$allow_func = [
    'main',
    'onecat2s',
    'config1',
    'config2',
    'config2',
];

$submenu['cats'] = $lang_module['cat_manager'];
$submenu['onecat1s'] = $lang_module['onecat1_manager'];
$submenu['onecat2s'] = $lang_module['onecat2_manager'];
$submenu['config1'] = $lang_module['config1'];
$submenu['config2'] = $lang_module['config2'];

// Xác chức năng ví dụ khác.
$submenu['notification'] = $lang_module['notify'];
$submenu['excel'] = $lang_module['excel'];
$submenu['pdf'] = $lang_module['pdf'];
$submenu['multifileimage'] = $lang_module['multifileimage'];

$allow_func[] = 'notification'; // Function ví dụ cách dùng thông báo hệ thống
$allow_func[] = 'excel'; // Function ví dụ nhập/xuất excel
$allow_func[] = 'pdf'; // Function ví dụ xuất PDF
$allow_func[] = 'multifileimage'; // Function ví dụ xử lý đính kèm nhiều file, ảnh