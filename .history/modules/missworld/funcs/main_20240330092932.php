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
    foreach ($list as $row) {
        if ($row['exp_time'] > 0 and $row['exp_time'] < NV_CURRENTTIME) {
            $is_update[] = $row['vid'];
        } elseif ($row['publ_time'] <= NV_CURRENTTIME and nv_user_in_groups($row['groups_view'])) {
            $allowed[$a] = $row;
            ++$a;
        }
    }

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
            $xtpl->assign('VOTING', $voting_array);

            $sql = 'SELECT id, vid, title, url FROM ' . NV_PREFIXLANG . '_' . $site_mods['voting']['module_data'] . '_rows WHERE vid = ' . $current_voting['vid'] . ' ORDER BY id ASC';
            $list = $nv_Cache->db($sql, '', $module_name);

            foreach ($list as $row) {
                if (!empty($row['url'])) {
                    $row['title'] = '<a target="_blank" href="' . $row['url'] . '">' . $row['title'] . '</a>';
                }
                $xtpl->assign('RESULT', $row);
                if ((int) $current_voting['acceptcm'] > 1) {
                    $xtpl->parse('main.loop.resultn');
                } else {
                    $xtpl->parse('main.loop.result1');
                }
            }

            if ($voting_array['active_captcha']) {
                if ($module_captcha == 'recaptcha' and $global_config['recaptcha_ver'] == 3) {
                    $xtpl->parse('main.loop.recaptcha3');
                } elseif (($module_captcha == 'recaptcha' and $global_config['recaptcha_ver'] == 2) or $module_captcha == 'captcha') {
                    if ($module_captcha == 'recaptcha' and $global_config['recaptcha_ver'] == 2) {
                        $xtpl->assign('RECAPTCHA_ELEMENT', 'recaptcha' . nv_genpass(8));
                        $xtpl->assign('N_CAPTCHA', $lang_global['securitycode1']);
                        $xtpl->parse('main.loop.has_captcha.recaptcha');
                    } else {
                        $xtpl->assign('N_CAPTCHA', $lang_global['securitycode']);
                        $xtpl->assign('CAPTCHA_REFRESH', $lang_global['captcharefresh']);
                        $xtpl->assign('GFX_WIDTH', NV_GFX_WIDTH);
                        $xtpl->assign('GFX_HEIGHT', NV_GFX_HEIGHT);
                        $xtpl->assign('SRC_CAPTCHA', NV_BASE_SITEURL . 'index.php?scaptcha=captcha&t=' . NV_CURRENTTIME);
                        $xtpl->assign('GFX_MAXLENGTH', NV_GFX_NUM);
                        $xtpl->parse('main.loop.has_captcha.basic');
                    }
                    $xtpl->parse('main.loop.has_captcha');
                }
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
}
}

$contents = nv_missworld_list($array_data);


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';