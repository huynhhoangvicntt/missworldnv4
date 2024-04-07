<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['onecat2_manager'];

// Lấy liên kết tĩnh
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

$xtpl = new XTemplate('onecat2s.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('CAPTION', $caption);
$xtpl->assign('FORM_ACTION', $form_action);
$xtpl->assign('DATA', $array);

$xtpl->assign('UPLOAD_CURRENT', $currentpath);
$xtpl->assign('UPLOAD_PATH', NV_UPLOADS_DIR . '/' . $module_upload);

// Xuất danh sách
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s ORDER BY weight ASC";
$array_onecat2s = $db->query($sql)->fetchAll();
$num = sizeof($array_onecat2s);

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

// Hiển thị lỗi
if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

// Tự động lấy alias mỗi khi thêm tiêu đề
if (empty($array['alias'])) {
    $xtpl->parse('main.getalias');
}

// Hiển thị nút thêm
if (!$is_edit) {
    $xtpl->parse('main.add_btn');
}

// Cuộn đến form
if ($is_submit_form or $is_edit) {
    $xtpl->parse('main.scroll');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';