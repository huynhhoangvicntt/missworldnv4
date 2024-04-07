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
 * @param array $array
 * @param array $generate_page
 * @return string
 */
function nv_theme_main($array, $generate_page)
{
    global $lang_module, $lang_global, $module_info, $module_name, $module_file, $op_file;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('OP', $op_file);

    // Gọi hàm xử lý chung giao diện dạng danh sách, xuất ra HTML
    $xtpl->assign('HTML', nv_theme_item_list($array));

    // Phân trang nếu có
    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    if ($nv_Request->get_title('changealias', 'post', '') === NV_CHECK_SESSION) {
        $title = $nv_Request->get_title('title', 'post', '');
        $id = $nv_Request->get_absint('id', 'post', 0);
    
        $alias = strtolower(change_alias($title));
    
        $stmt = $db->prepare("SELECT COUNT(*) FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id !=" . $id . " AND alias = :alias");
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->execute();
    
        if ($stmt->fetchColumn()) {
            $weight = $db->query("SELECT MAX(id) FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s")->fetchColumn();
            $weight = intval($weight) + 1;
            $alias = $alias . '-' . $weight;
        }
    
        include NV_ROOTDIR . '/includes/header.php';
        echo $alias;
        include NV_ROOTDIR . '/includes/footer.php';
    }
    
    // Thay đổi thứ tự
    if ($nv_Request->get_title('changeweight', 'post', '') === NV_CHECK_SESSION) {
        $id = $nv_Request->get_absint('id', 'post', 0);
        $new_weight = $nv_Request->get_absint('new_weight', 'post', 0);
    
        // Kiểm tra tồn tại
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id=" . $id;
        $array = $db->query($sql)->fetch();
        if (empty($array)) {
            nv_htmlOutput('NO_' . $id);
        }
        if (empty($new_weight)) {
            nv_htmlOutput('NO_' . $id);
        }
    
        $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id!=" . $id . " ORDER BY weight ASC";
        $result = $db->query($sql);
    
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s SET weight=" . $weight . " WHERE id=" . $row['id'];
            $db->query($sql);
        }
    
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s SET weight=" . $new_weight . " WHERE id=" . $id;
        $db->query($sql);
    
        nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_CHANGE_WEIGHT_ONECAT2', json_encode($array), $admin_info['admin_id']);
        $nv_Cache->delMod($module_name);
        nv_htmlOutput('OK_' . $id);
    }
    
    // Thay đổi hoạt động
    if ($nv_Request->get_title('changestatus', 'post', '') === NV_CHECK_SESSION) {
        $id = $nv_Request->get_absint('id', 'post', 0);
    
        // Kiểm tra tồn tại
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id=" . $id;
        $array = $db->query($sql)->fetch();
        if (empty($array)) {
            nv_htmlOutput('NO_' . $id);
        }
    
        $status = empty($array['status']) ? 1 : 0;
    
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s SET status = " . $status . " WHERE id = " . $id;
        $db->query($sql);
    
        nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_CHANGE_STATUS_ONECAT2', json_encode($array), $admin_info['admin_id']);
        $nv_Cache->delMod($module_name);
    
        nv_htmlOutput("OK");
    }
    
    // Xóa
    if ($nv_Request->get_title('delete', 'post', '') === NV_CHECK_SESSION) {
        $id = $nv_Request->get_absint('id', 'post', 0);
    
        // Kiểm tra tồn tại
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id=" . $id;
        $array = $db->query($sql)->fetch();
        if (empty($array)) {
            nv_htmlOutput('NO_' . $id);
        }
    
        // Xóa
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id=" . $id;
        $db->query($sql);
    
        // Cập nhật thứ tự
        $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s ORDER BY weight ASC";
        $result = $db->query($sql);
        $weight = 0;
    
        while ($row = $result->fetch()) {
            ++$weight;
            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s SET weight=" . $weight . " WHERE id=" . $row['id'];
            $db->query($sql);
        }
    
        nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_DELETE_ONECAT2', json_encode($array), $admin_info['admin_id']);
        $nv_Cache->delMod($module_name);
    
        nv_htmlOutput("OK");
    }
    
    $array = $error = [];
    $is_submit_form = $is_edit = false;
    $id = $nv_Request->get_absint('id', 'get', 0);
    $currentpath = NV_UPLOADS_DIR . '/' . $module_upload;
    
    if (!empty($id)) {
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE id = " . $id;
        $result = $db->query($sql);
        $array = $result->fetch();
    
        if (empty($array)) {
            nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
        }
    
        $is_edit = true;
        $caption = $lang_module['onecat2_edit'];
        $form_action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $id;
    } else {
        $array = [
            'id' => 0,
            'title' => '',
            'alias' => '',
            'image' => '',
            'keywords' => '',
            'description' => '',
        ];
    
        $caption = $lang_module['onecat2_add'];
        $form_action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
    }
    
    if ($nv_Request->get_title('save', 'post', '') === NV_CHECK_SESSION) {
        $is_submit_form = true;
        $array['title'] = nv_substr($nv_Request->get_title('title', 'post', ''), 0, 190);
        $array['alias'] = nv_substr($nv_Request->get_title('alias', 'post', ''), 0, 190);
        $array['image'] = nv_substr($nv_Request->get_string('image', 'post', ''), 0, 255);
        $array['keywords'] = $nv_Request->get_title('keywords', 'post', '');
        $array['description'] = $nv_Request->get_string('description', 'post', '');
    
        // Xử lý dữ liệu
        $array['alias'] = empty($array['alias']) ? change_alias($array['title']) : change_alias($array['alias']);
        $array['description'] = nv_nl2br(nv_htmlspecialchars(strip_tags($array['description'])), '<br />');
    
        if (nv_is_file($array['image'], NV_UPLOADS_DIR . '/' . $module_upload)) {
            $array['image'] = substr($array['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
        } else {
            $array['image'] = '';
        }
    
        // Kiểm tra trùng
        $is_exists = false;
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s WHERE alias = :alias" . ($id ? ' AND id != ' . $id : '');
        $sth = $db->prepare($sql);
        $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
        $sth->execute();
        if ($sth->fetchColumn()) {
            $is_exists = true;
        }
    
        if (empty($array['title'])) {
            $error[] = $lang_module['onecat2_error_title'];
        } elseif ($is_exists) {
            $error[] = $lang_module['onecat2_error_exists'];
        }
    
        if (empty($error)) {
            if (!$id) {
                $sql = "SELECT MAX(weight) weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s";
                $weight = intval($db->query($sql)->fetchColumn()) + 1;
    
                $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s (
                    title, alias, image, keywords, description, weight, add_time, edit_time
                ) VALUES (
                    :title, :alias, :image, :keywords, :description, " . $weight . ", " . NV_CURRENTTIME . ", 0
                )";
            } else {
                $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s SET
                    title = :title, alias = :alias, image = :image, keywords = :keywords,
                    description = :description, edit_time = " . NV_CURRENTTIME . "
                WHERE id = " . $id;
            }
    
            try {
                $sth = $db->prepare($sql);
                $sth->bindParam(':title', $array['title'], PDO::PARAM_STR);
                $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
                $sth->bindParam(':image', $array['image'], PDO::PARAM_STR);
                $sth->bindParam(':keywords', $array['keywords'], PDO::PARAM_STR, strlen($array['keywords']));
                $sth->bindParam(':description', $array['description'], PDO::PARAM_STR, strlen($array['description']));
                $sth->execute();
    
                if ($id) {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_EDIT_ONECAT2', json_encode($array), $admin_info['userid']);
                } else {
                    nv_insert_logs(NV_LANG_DATA, $module_name, 'LOG_ADD_ONECAT2', json_encode($array), $admin_info['userid']);
                }
    
                $nv_Cache->delMod($module_name);
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            } catch (PDOException $e) {
                trigger_error(print_r($e, true));
                $error[] = $lang_module['errorsave'];
            }
        }
    }
    
    if (!empty($array['image']) and nv_is_file(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array['image'], NV_UPLOADS_DIR . '/' . $module_upload)) {
        $array['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array['image'];
        $currentpath = substr(dirname($array['image']), strlen(NV_BASE_SITEURL));
    }
    $array['description'] = nv_br2nl($array['description']);
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