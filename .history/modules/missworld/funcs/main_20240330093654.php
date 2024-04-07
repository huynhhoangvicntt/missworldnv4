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

    $allowed = [];
    $is_update = [];

    $a = 0;

    if (!empty($is_update)) {
        $is_update = implode(',', $is_update);

        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET act=0 WHERE vid IN (' . $is_update . ')';
        $db->query($sql);

        $nv_Cache->delMod($module_name);
    }

    if (!empty($allowed)) {
        $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
        $xtpl->assign('LANG', $lang_module);

        foreach ($allowed as $current_voting) {
            $voting_array = [
                'checkss' => md5($current_voting['id'] . NV_CHECK_SESSION),
                'action' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name,
                'langresult' => $lang_module['voting_result'],
                'langsubmit' => $lang_module['voting_hits'],
                'birthday' => nv_date('l - d/m/Y H:i', $current_voting['birthday'])
            ];
            $xtpl->assign('VOTING', $voting_array);

            $sql = 'SELECT id, name, birthday, url FROM ' . NV_PREFIXLANG . '_' . $site_mods['voting']['module_data'] . '_missworld WHERE id = ' . $current_voting['vid'] . ' ORDER BY id ASC';
            $list = $nv_Cache->db($sql, '', $module_name);
            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
}
}

$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';