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
    $array_data[$row["vote_count"]] = $row;
    
}
$id = $nv_request->get_title('id', 'POST') .'';
    // Lấy dữ liệu bình chọn từ request
    $voteCount = $_POST["voteCount"];

    // Lưu dữ liệu bình chọn vào cơ sở dữ liệu (ở đây mình giả sử sử dụng MySQL)
    // Code thực hiện kết nối và lưu dữ liệu vào cơ sở dữ liệu sẽ được thêm ở đây

    // Phản hồi cho client rằng dữ liệu đã được lưu thành công
    echo "Vote data saved successfully!";


$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';