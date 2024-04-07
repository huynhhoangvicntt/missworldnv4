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

// Lấy ra bài viết xem chi tiết
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE alias=" . $db->quote($array_op[1]) . " AND status=1";
$row = $db->query($sql)->fetch();
if (empty($row) or !isset($global_array_cats[$row['catid']])) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'], 404);
}

// Các biến cần thiết: Tiêu đề, từ khóa, mô tả
$page_title = $row['title'];
$key_words = $row['keywords'];
$description = $row['description'];

// Các biết cần thiết: Link của trang
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cats[$row['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];
$canonicalUrl = getCanonicalUrl($page_url);

// Meta OG chia sẻ facebook, zalo, dữ liệu có cấu trúc
$structured_data = [
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $row['title'],
    'datePublished' => date('c', $row['add_time']),
    'author' => [[
        '@type' => 'Person',
        'name' => 'Admin',
        'url' => NV_MY_DOMAIN,
    ]]
];
if (!empty($row['edit_time'])) {
    $structured_data['dateModified'] = date('c', $row['edit_time']);
}

if ($row['is_thumb'] == 3) {
    $meta_property['og:image'] = $row['image'];
    $structured_data['image'] = [$meta_property['og:image']];
} elseif ($row['is_thumb'] > 0) {
    $meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'];
    $structured_data['image'] = [$meta_property['og:image']];
} elseif (!empty($global_array_cats[$row['catid']]['image'])) {
    $meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $global_array_cats[$row['catid']]['image'];
    $structured_data['image'] = [$meta_property['og:image']];
}

$row['structured_data'] = json_encode($structured_data, JSON_PRETTY_PRINT);

// Xử lý số lượt xem
$time_set = $nv_Request->get_int($module_data . '_' . $op . '_' . $row['id'], 'session');
if (empty($time_set)) {
    $nv_Request->set_Session($module_data . '_' . $op . '_' . $row['id'], NV_CURRENTTIME);
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET view_hits=view_hits+1 WHERE id=" . $row['id'];
    $db->query($sql);
    $row['view_hits']++;
}

// Xử lý bình luận
if (isset($site_mods['comment']) and isset($module_config[$module_name]['activecomm'])) {
    // Định nghĩa ID bài viết và khu vực comment (bắt buộc)
    define('NV_COMM_ID', $row['id']);
    define('NV_COMM_AREA', $module_info['funcs'][$op]['func_id']);

    // Xác định quyền comment
    $allowed = $module_config[$module_name]['allowed_comm'];
    if ($allowed == '-1') {
        // Quyền tùy theo bài. Dạng list các nhóm. Ở đây fix cứng 4, các module khác tùy ý có thể có giá trị khác
        $allowed = '4';
    }
    require_once NV_ROOTDIR . '/modules/comment/comment.php';
    $checkss = md5($module_name . '-' . NV_COMM_AREA . '-' . NV_COMM_ID . '-' . $allowed . '-' . NV_CACHE_PREFIX);

    $row['comment_content'] = nv_comment_module($module_name, $checkss, NV_COMM_AREA, NV_COMM_ID, $allowed, 1);
} else {
    $row['comment_content'] = '';
}

// Tin mới hơn, cũ hơn
$array_news = $array_olds = [];

$sql = "SELECT id, catid, title, alias, description, image, is_thumb, admin_id, add_time
FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE status=1 AND id!=" . $row['id'] . "
AND add_time>" . $row['add_time'] . " AND (
    catid=" . $row['catid'] . " OR FIND_IN_SET(" . $row['catid'] . ", catids)
) ORDER BY add_time DESC LIMIT " . $per_page_detail;
$result = $db->query($sql);
while ($item = $result->fetch()) {
    // Xác định ảnh đại diện
    if ($item['is_thumb'] == 1) {
        // Ảnh nhỏ assets
        $item['thumb'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $item['image'];
        $item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['image'];
    } elseif ($item['is_thumb'] == 2) {
        // Ảnh upload lớn
        $item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['image'];
        $item['thumb'] = $item['image'];
    } elseif ($item['is_thumb'] == 3) {
        // Ảnh remote
        $item['thumb'] = $item['image'];
    } else {
        // Không có ảnh
        $item['thumb'] = $item['image'] = '';
    }

    // Xác định link bài
    if (isset($global_array_cats[$item['catid']])) {
        $item['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cats[$item['catid']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];
    } else {
        $item['link'] = '#';
    }

    $array_news[$item['id']] = $item;
}

$sql = "SELECT id, catid, title, alias, description, image, is_thumb, admin_id, add_time
FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE status=1 AND id!=" . $row['id'] . "
AND add_time<" . $row['add_time'] . " AND (
    catid=" . $row['catid'] . " OR FIND_IN_SET(" . $row['catid'] . ", catids)
) ORDER BY add_time DESC LIMIT " . $per_page_detail;
$result = $db->query($sql);
while ($item = $result->fetch()) {
    // Xác định ảnh đại diện
    if ($item['is_thumb'] == 1) {
        // Ảnh nhỏ assets
        $item['thumb'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $item['image'];
        $item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['image'];
    } elseif ($item['is_thumb'] == 2) {
        // Ảnh upload lớn
        $item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['image'];
        $item['thumb'] = $item['image'];
    } elseif ($item['is_thumb'] == 3) {
        // Ảnh remote
        $item['thumb'] = $item['image'];
    } else {
        // Không có ảnh
        $item['thumb'] = $item['image'] = '';
    }

    // Xác định link bài
    if (isset($global_array_cats[$item['catid']])) {
        $item['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cats[$item['catid']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];
    } else {
        $item['link'] = '#';
    }

    $array_olds[$item['id']] = $item;
}

// Gọi hàm xử lý giao diện
$contents = nv_theme_detail($row, $array_news, $array_olds);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';