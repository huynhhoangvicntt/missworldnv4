<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_LIBS')) {
    exit('Stop!!!');
}

/**
 * @param array $array
 * @param array  $row
 * @param array $generate_page
 * @return string
 */
function nv_theme_main($array, $generate_page)
{
    global $lang_module, $lang_global, $module_info, $module_name, $module_file, $op_file, $module_upload;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('OP', $op_file);
    foreach ($array_onecat2s as $row) {
        $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $row['id'];
        $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR. '/' . $module_upload. '/' . $row['image'];
        $row['status_render'] = empty($row['status']) ? '' : ' checked="checked"';
    
        for ($i = 1; $i <= $num; ++$i) {
            $xtpl->assign('WEIGHT', [
                'w' => $i,
                'selected' => ($i == $row['weight']) ? ' selected="selected"' : ''
            ]);
    
            $xtpl->parse('main.loop.weight');
        }
    
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }

    // Gọi hàm xử lý chung giao diện dạng danh sách, xuất ra HTML
    $xtpl->assign('HTML', nv_theme_item_list($array));

   

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * @param array $array
 * @param string $generate_page
 * @param array $cat
 * @return string
 */
function nv_theme_viewcat($array, $generate_page, $cat)
{
    global $lang_module, $lang_global, $module_info, $module_name, $module_file, $op_file;

    $xtpl = new XTemplate('viewcat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('OP', $op_file);

    // Xuất danh mục
    $xtpl->assign('CAT', $cat);

    // Gọi hàm xử lý chung giao diện dạng danh sách, xuất ra HTML
    $xtpl->assign('HTML', nv_theme_item_list($array));

    // Phân trang nếu có
    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_theme_search($array, $generate_page, $is_search, $num_items, $array_search)
{
    global $lang_module, $lang_global, $module_info, $module_name, $module_file, $op_file, $global_config, $op;

    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('OP', $op_file);

    if (!$global_config['rewrite_enable']) {
        $xtpl->assign('FORM_ACTION', NV_BASE_SITEURL . 'index.php');
        $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
        $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
        $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
        $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
        $xtpl->assign('OP', $op);
        $xtpl->parse('main.no_rewrite');
    } else {
        $xtpl->assign('FORM_ACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
    }

    // Chuyển tìm kiếm sang ngày tháng
    $array_search['from'] = empty($array_search['from']) ? '' : nv_date('d-m-Y', $array_search['from']);
    $array_search['to'] = empty($array_search['to']) ? '' : nv_date('d-m-Y', $array_search['to']);

    $xtpl->assign('SEARCH', $array_search);

    if (!$is_search) {
        $xtpl->parse('main.please');
    } elseif (empty($array)) {
        $xtpl->parse('main.empty');
    } else {
        $xtpl->assign('NUM_ITEMS', number_format($num_items, 0, ',', '.'));

        // Gọi hàm xử lý chung giao diện dạng danh sách, xuất ra HTML
        $xtpl->assign('HTML', nv_theme_item_list($array));
        $xtpl->parse('main.data');
    }

    // Phân trang nếu có
    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * @param array $row
 * @param array $array_news
 * @param array $array_olds
 * @return string
 */
function nv_theme_detail($row, $array_news, $array_olds)
{
    global $lang_module, $lang_global, $module_info, $module_name, $module_file, $op_file;

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('OP', $op_file);

    $row['add_time'] = nv_date('H:i d/m/Y', $row['add_time']);
    $row['view_hits'] = number_format($row['view_hits'], 0, ',', '.');
    $row['comment_hits'] = number_format($row['comment_hits'], 0, ',', '.');

    $xtpl->assign('ROW', $row);

    // Giới thiệu gắn gọn nếu có
    if (!empty($row['description'])) {
        $xtpl->parse('main.description');
    }

    // Xuất bình luận nếu có
    if (!empty($row['comment_content'])) {
        $xtpl->parse('main.comment');
    }

    // Tin mới hơn
    if (!empty($array_news)) {
        foreach ($array_news as $item) {
            if (empty($item['thumb'])) {
                $item['thumb'] = NV_BASE_SITEURL . 'themes/default/images/' . $module_info['module_theme'] . '/no-image.png';
            }
            $item['add_time'] = nv_date('H:i d/m/Y', $item['add_time']);

            $xtpl->assign('ITEM', $item);
            $xtpl->parse('main.new.loop');
        }
        $xtpl->parse('main.new');
    }

    // Tin cũ hơn
    if (!empty($array_olds)) {
        foreach ($array_olds as $item) {
            if (empty($item['thumb'])) {
                $item['thumb'] = NV_BASE_SITEURL . 'themes/default/images/' . $module_info['module_theme'] . '/no-image.png';
            }
            $item['add_time'] = nv_date('H:i d/m/Y', $item['add_time']);

            $xtpl->assign('ITEM', $item);
            $xtpl->parse('main.old.loop');
        }
        $xtpl->parse('main.old');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * @param array $array
 * @return string
 */
function nv_theme_item_list($array)
{
    global $lang_module, $lang_global, $module_info;

    $xtpl = new XTemplate('item-list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    foreach ($array as $row) {
        $row['add_time'] = nv_date('H:i d/m/Y', $row['add_time']);
        $row['title_text'] = $row['title_text'] ?? $row['title'];

        $xtpl->assign('ROW', $row);

        if (!empty($row['thumb'])) {
            $xtpl->parse('main.loop.image');
        }

        $xtpl->parse('main.loop');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}