<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_MISSWORLD')) {
    exit('Stop!!!');
}

//Lấy dữ liệu
$array_data = [];

$query = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_missworld");
while ($row = $query->fetch()){
    $array_data[$row["id"]] = $row;
}

if ($nv_Request->isset_request('submit2', 'post')){
  
    $row['vote_count'] = $nv_Request->get_int('vote_count', 'post', '');    
            $exe = $sth->execute();
            if($exe){
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
             }
        }  


$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';