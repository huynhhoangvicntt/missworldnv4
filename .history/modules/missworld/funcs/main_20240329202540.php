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

if (!empty($array)) {
    $vote = $_POST["vote"];

    // Tăng số lượt bình chọn cho lựa chọn được chọn
    $sql = 'UPDATE ' . NV_PREFIXLANG .  '_' . $module_data . '_missworld SET vote_count = vote_count + 1 WHERE id =' . ' AND id IN (' . $in . ')';

    if ($conn->query($sql) === TRUE) {
        echo "Bình chọn thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';