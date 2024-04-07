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

if (!empty($allowed)) {
    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);

    foreach ($allowed as $current_voting) {
        $voting_array = [
            'checkss' => md5($current_voting['vid'] . NV_CHECK_SESSION),
            'accept' => (int) $current_voting['acceptcm'],
            'active_captcha' => (int) $current_voting['active_captcha'],
            'errsm' => (int) $current_voting['acceptcm'] > 1 ? sprintf($lang_module['voting_warning_all'], (int) $current_voting['acceptcm']) : $lang_module['voting_warning_accept1'],
            'vid' => $current_voting['vid'],
            'question' => (empty($current_voting['link'])) ? $current_voting['question'] : '<a target="_blank" href="' . $current_voting['link'] . '">' . $current_voting['question'] . '</a>',
            'action' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name,
            'langresult' => $lang_module['voting_result'],
            'langsubmit' => $lang_module['voting_hits'],
            'publtime' => nv_date('l - d/m/Y H:i', $current_voting['publ_time'])
        ];


$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';