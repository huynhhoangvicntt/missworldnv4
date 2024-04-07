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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedOption = $_POST['option'];
        
        // Tăng số lượng phiếu bầu cho tùy chọn đã chọn
        $sql = "UPDATE options SET vote_count = vote_count + 1 WHERE option_name = '$selectedOption'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Vote successfully recorded.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';