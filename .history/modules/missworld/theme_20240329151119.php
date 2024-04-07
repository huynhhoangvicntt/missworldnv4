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

/**
 * nv_page_main()
 *
 * @param array $voting
 * @param array  $row
 * @param array  $ab_links
 * @param string $content_comment
 * @return string
 */
function nv_missworld_list($array_data)
{
    global $module_name, $lang_module, $lang_global, $module_info, $meta_property, $client_info, $page_config, $global_config, $module_upload, $image;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    if(!empty($array_data)){
        foreach($array_data as $value){
            $value['birthday'] = nv_date('d/m/Y', $value['birthday']);
            $value['avatar'] = NV_BASE_SITEURL . NV_UPLOADS_DIR. '/' . $module_upload. '/' . $value['avatar'];
            $xtpl->assign('DATA', $value);
            $xtpl->parse('main.loop');
        }
    }
    if (isset($voting['row'])) {
        $a = 1;
        $b = 0;
        foreach ($voting['row'] as $voting_i) {
            if ($voting['total']) {
                $width = ($voting_i['hitstotal'] / $voting['total']) * 100;
                $width = round($width, 2);
            } else {
                $width = 0;
            }

            if ($width) {
                ++$b;
            }

            $xtpl->assign('VOTING', $voting_i);
            $xtpl->assign('BG', (($b % 2 == 1) ? 'background-color: rgb(0, 102, 204);' : ''));
            $xtpl->assign('ID', $a);
            $xtpl->assign('WIDTH', $width);
            $xtpl->assign('TOTAL', $voting['total']);
            if ($voting_i['title']) {
                $xtpl->parse('main.result');
            }
            ++$a;
        }
    }
    $xtpl->parse('main');

    return $xtpl->text('main');
}