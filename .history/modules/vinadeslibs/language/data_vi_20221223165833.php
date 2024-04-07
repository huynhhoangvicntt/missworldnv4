<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

/**
 * Các biến khả dụng:
 * 	Liên quan module này: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
 * 	Liên quan đến toàn hệ thống: $db, $db_config, $global_config
 *  Các biến hệ thống khác muốn dùng thì gọi global
 */

require_once NV_ROOTDIR . '/modules/' . $module_file . '/LoremIpsum.php';
$lipsum = new LoremIpsum();

/**
 * @param number $num
 * @return array|NULL[]
 */
function getKeywrods($num = 1)
{
    $words = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
        'a', 'ac', 'accumsan', 'ad', 'aenean', 'aliquam', 'aliquet', 'ante',
        'aptent', 'arcu', 'at', 'auctor', 'augue', 'bibendum', 'blandit',
        'class', 'commodo', 'condimentum', 'congue', 'consequat', 'conubia',
        'convallis', 'cras', 'cubilia', 'curabitur', 'curae', 'cursus',
        'dapibus', 'diam', 'dictum', 'dictumst', 'dignissim', 'dis', 'donec',
        'dui', 'duis', 'efficitur', 'egestas', 'eget', 'eleifend', 'elementum',
        'enim', 'erat', 'eros', 'est', 'et', 'etiam', 'eu', 'euismod', 'ex',
        'facilisi', 'facilisis', 'fames', 'faucibus', 'felis', 'fermentum',
        'feugiat', 'finibus', 'fringilla', 'fusce', 'gravida', 'habitant',
        'habitasse', 'hac', 'hendrerit', 'himenaeos', 'iaculis', 'id',
        'imperdiet', 'in', 'inceptos', 'integer', 'interdum', 'justo',
        'lacinia', 'lacus', 'laoreet', 'lectus', 'leo', 'libero', 'ligula',
        'litora', 'lobortis', 'luctus', 'maecenas', 'magna', 'magnis',
        'malesuada', 'massa', 'mattis', 'mauris', 'maximus', 'metus', 'mi',
        'molestie', 'mollis', 'montes', 'morbi', 'mus', 'nam', 'nascetur',
        'natoque', 'nec', 'neque', 'netus', 'nibh', 'nisi', 'nisl', 'non',
        'nostra', 'nulla', 'nullam', 'nunc', 'odio', 'orci', 'ornare',
        'parturient', 'pellentesque', 'penatibus', 'per', 'pharetra',
        'phasellus', 'placerat', 'platea', 'porta', 'porttitor', 'posuere',
        'potenti', 'praesent', 'pretium', 'primis', 'proin', 'pulvinar',
        'purus', 'quam', 'quis', 'quisque', 'rhoncus', 'ridiculus', 'risus',
        'rutrum', 'sagittis', 'sapien', 'scelerisque', 'sed', 'sem', 'semper',
        'senectus', 'sociosqu', 'sodales', 'sollicitudin', 'suscipit',
        'suspendisse', 'taciti', 'tellus', 'tempor', 'tempus', 'tincidunt',
        'torquent', 'tortor', 'tristique', 'turpis', 'ullamcorper', 'ultrices',
        'ultricies', 'urna', 'ut', 'varius', 'vehicula', 'vel', 'velit',
        'venenatis', 'vestibulum', 'vitae', 'vivamus', 'viverra', 'volutpat',
        'vulputate',
    ];

    $array_tags = [];
    while (1) {
        $word = [$words[array_rand($words)], $words[array_rand($words)]];
        if (sizeof(array_unique($word)) != 2) {
            continue;
        }
        foreach ($word as $word_i) {
            if (mb_strlen($word_i) <= 3) {
                continue 2;
            }
        }
        $array_tags[] = implode(' ', $word);
        $array_tags = array_unique($array_tags);
        if (sizeof($array_tags) >= $num) {
            break;
        }
    }
    return $array_tags;
}

$lipsum->tb = 24.46;
$lipsum->lc = 5.08;
$lipsum->is_coma = false;
$lipsum->is_end = false;
$lipsum->minmax = [2, 3];

$titles = $lipsum->sentencesArray(3000);

$lipsum->is_coma = true;
$lipsum->is_end = true;
$lipsum->minmax = [];
$descriptions = $lipsum->sentencesArray(3000);

/*
 * Dữ liệu mẫu chủ đề. Kịch bản có 10 chủ đề, chủ đề 2 có 5 chủ đề con và chủ đề 3,4 của nó có 7 chủ đề con mỗi loại
 */
$sort = 0;
$array_catids = [];
for ($i = 1; $i <= 10; $i++) {
    $sort++;

    $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_cats (
        id, parentid, title, alias, description, image, weight, sort, lev,
        numsubcat, subcatid, keywords, add_time, edit_time, status
    ) VALUES (
        " . $i . ", 0, " . $db->quote($titles[$i]) . ",
        " . $db->quote(strtolower(change_alias($titles[$i]))) . ",
        " . $db->quote($descriptions[$i]) . ",
        'img" . random_int(1, 10) . ".jpg', " . $i . ", " . $sort . ", 0, 0, '',
        " . $db->quote(implode(', ', getKeywrods(10))) . ",
        " . NV_CURRENTTIME . ", 0, 1
    )";
    $db->query($sql);
    $array_catids[] = $i;

    // Thêm cấp 2
    if ($i == 2) {
        $numsub = 0;
        $sub_ids = [];

        for ($j = 1; $j <= 5; $j++) {
            $id = $i * 1000 + $j * 100;
            $sort++;
            $numsub++;
            $sub_ids[] = $id;

            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_cats (
                id, parentid, title, alias, description, image, weight, sort, lev,
                numsubcat, subcatid, keywords, add_time, edit_time, status
            ) VALUES (
                " . $id . ", " . $i . ", " . $db->quote($titles[$id]) . ",
                " . $db->quote(strtolower(change_alias($titles[$id]))) . ",
                " . $db->quote($descriptions[$id]) . ",
                'img" . random_int(1, 10) . ".jpg', " . $j . ", " . $sort . ", 1, 0, '',
                " . $db->quote(implode(', ', getKeywrods(10))) . ",
                " . NV_CURRENTTIME . ", 0, 1
            )";
            $db->query($sql);
            $array_catids[] = $id;

            // Thêm cấp 3
            if (in_array($j, [3, 4])) {
                $numsub3 = 0;
                $sub3_ids = [];

                for ($k = 1; $k <= 7; $k++) {
                    $id3 = $i * 1000 + $j * 100 + $k;
                    $sort++;
                    $numsub3++;
                    $sub3_ids[] = $id3;

                    $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_cats (
                        id, parentid, title, alias, description, image, weight, sort, lev,
                        numsubcat, subcatid, keywords, add_time, edit_time, status
                    ) VALUES (
                        " . $id3 . ", " . $id . ", " . $db->quote($titles[$id3]) . ",
                        " . $db->quote(strtolower(change_alias($titles[$id3]))) . ",
                        " . $db->quote($descriptions[$id3]) . ",
                        'img" . random_int(1, 10) . ".jpg', " . $k . ", " . $sort . ", 2, 0, '',
                        " . $db->quote(implode(', ', getKeywrods(10))) . ",
                        " . NV_CURRENTTIME . ", 0, 1
                    )";
                    $db->query($sql);
                    $array_catids[] = $id3;
                }

                // Cập nhật lại numsub và subid cho lev=0
                $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cats SET
                    numsubcat=" . $numsub3 . ",
                    subcatid=" . $db->quote(implode(',', $sub3_ids)) . "
                WHERE id=" . $id;
                $db->query($sql);
            }
        }

        // Cập nhật lại numsub và subid cho lev=0
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cats SET
            numsubcat=" . $numsub . ",
            subcatid=" . $db->quote(implode(',', $sub_ids)) . "
        WHERE id=" . $i;
        $db->query($sql);
    }
}

/**
 * Dữ liệu mẫu danh mục 1 cấp dạng 1, dạng 2
 */
$lipsum->tb = 24.46;
$lipsum->lc = 5.08;
$lipsum->is_coma = false;
$lipsum->is_end = false;
$lipsum->minmax = [2, 3];

$titles = $lipsum->sentencesArray(100);

$lipsum->is_coma = true;
$lipsum->is_end = true;
$lipsum->minmax = [];
$descriptions = $lipsum->sentencesArray(100);

for ($i = 1; $i <= 5; $i++) {
    $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_onecat1s (
        id, title, description, add_time, edit_time, weight, status
    ) VALUES (
        " . $i . ", " . $db->quote($titles[$i]) . ",
        " . $db->quote($descriptions[$i]) . ",
        " . NV_CURRENTTIME . ", 0, " . $i . ", 1
    )";
    $db->query($sql);
}

$lipsum->tb = 24.46;
$lipsum->lc = 5.08;
$lipsum->is_coma = false;
$lipsum->is_end = false;
$lipsum->minmax = [2, 3];

$titles = $lipsum->sentencesArray(100);

$lipsum->is_coma = true;
$lipsum->is_end = true;
$lipsum->minmax = [];
$descriptions = $lipsum->sentencesArray(100);

for ($i = 1; $i <= 5; $i++) {
    $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s (
        id, title, alias, image, keywords, description, add_time, edit_time, weight, status
    ) VALUES (
        " . $i . ", " . $db->quote($titles[$i]) . ", " . $db->quote(strtolower(change_alias($titles[$i]))) . ",
        'img" . random_int(1, 10) . ".jpg', " . $db->quote(implode(', ', getKeywrods(10))) . ",
        " . $db->quote($descriptions[$i]) . ",
        " . NV_CURRENTTIME . ", 0, " . $i . ", 1
    )";
    $db->query($sql);
}

/**
 * Dữ liệu mẫu cho cấu hình chung
 */
$lipsum->is_coma = true;
$lipsum->is_end = true;
$lipsum->minmax = [];
$descriptions = $lipsum->sentencesArray(100);

$cfgs = [
    'cfg_image' => ('img' . random_int(1, 10) . '.jpg'),
    'cfg_textarea' => $descriptions[0] . '<br />' . $descriptions[1] . '<br />' . $descriptions[2],
    'cfg_textarea_html' => '<h1>' . $descriptions[3] . '</h1><br /><strong>' . $descriptions[4] . '</strong><br />' . $descriptions[5],
    'cfg_editor' => '<strong>' . $descriptions[6] . '</strong><br /><ul><li>' . $descriptions[7] . '</li><li>' . $descriptions[8] . '</li><li>' . $descriptions[9] . '</li></ul>',
    'cfg_date' => NV_CURRENTTIME,
    'cfg_fdatet_f' => NV_CURRENTTIME,
    'cfg_fdatet_t' => NV_CURRENTTIME + 86400,
    'cfg_dt' => NV_CURRENTTIME,
    'cfg_fdtt_f' => NV_CURRENTTIME,
    'cfg_fdtt_t' => NV_CURRENTTIME + 86400,
];
foreach ($cfgs as $config_name => $config_value) {
    $sql = "UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value=" . $db->quote($config_value) . "
    WHERE lang=" . $db->quote(NV_LANG_DATA) . " AND module=" . $db->quote($module_name) . "
    AND config_name=" . $db->quote($config_name);
    $db->query($sql);
}

/**
 * Dữ liệu mẫu cho cấu hình riêng
 */
$lipsum->is_coma = true;
$lipsum->is_end = true;
$lipsum->minmax = [];
$descriptions = $lipsum->sentencesArray(100);

$cfgs = [
    'cfg_image' => ('img' . random_int(1, 10) . '.jpg'),
    'cfg_textarea' => $descriptions[0] . '<br />' . $descriptions[1] . '<br />' . $descriptions[2],
    'cfg_textarea_html' => '<h1>' . $descriptions[3] . '</h1><br /><strong>' . $descriptions[4] . '</strong><br />' . $descriptions[5],
    'cfg_editor' => '<strong>' . $descriptions[6] . '</strong><br /><ul><li>' . $descriptions[7] . '</li><li>' . $descriptions[8] . '</li><li>' . $descriptions[9] . '</li></ul>',
    'cfg_date' => NV_CURRENTTIME,
    'cfg_fdatet_f' => NV_CURRENTTIME,
    'cfg_fdatet_t' => NV_CURRENTTIME + 86400,
    'cfg_dt' => NV_CURRENTTIME,
    'cfg_fdtt_f' => NV_CURRENTTIME,
    'cfg_fdtt_t' => NV_CURRENTTIME + 86400,
];
foreach ($cfgs as $config_name => $config_value) {
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_config SET config_value=" . $db->quote($config_value) . " WHERE config_name=" . $db->quote($config_name);
    $db->query($sql);
}

/**
 * Dữ liệu mẫu danh sách chính
 */
$lipsum->tb = 24.46;
$lipsum->lc = 5.08;
$lipsum->is_coma = false;
$lipsum->is_end = false;
$lipsum->minmax = [10, 15];

$titles = $lipsum->sentencesArray(20001);

$lipsum->is_coma = true;
$lipsum->is_end = true;
$lipsum->minmax = [];
$descriptions = $lipsum->sentencesArray(20001);

$id = 0;
for ($i = 1; $i <= 10; $i++) {
    $values = [];
    for ($j = 1; $j <= 1000; $j++) {
        $id++;

        // Ngẫu nhiên catid
        $catid = $array_catids[array_rand($array_catids)];
        $_catids = array_rand($array_catids, 4);
        $catids = [];
        foreach ($_catids as $_catids_i) {
            $catids[] = $array_catids[$_catids_i];
        }
        $catids[] = $catid;
        $catids = implode(',', array_unique($catids));

        // Build ngẫu nhiên mô tả
        $description = [];
        $rands = array_rand($descriptions, 2);
        foreach ($rands as $rand) {
            $description[] = $descriptions[$rand];
        }
        $description = implode(' ', $description);

        // Build ngẫu nhiên body html
        $bodyhtml = [];

        // 1 đoạn 5 câu
        $rands = array_rand($descriptions, 5);
        $para = [];
        foreach ($rands as $rand) {
            $para[] = $descriptions[$rand];
        }
        $bodyhtml[] = '<p>' . implode(' ', $para) . '</p>';

        // ul 5 dòng
        $bodyhtml[] = '<ul>';

        $rands = array_rand($descriptions, 5);
        foreach ($rands as $rand) {
            $bodyhtml[] = '<li>' . $descriptions[$rand] . '</li>';
        }

        $bodyhtml[] = '</ul>';

        // 1 đoạn 10 câu
        $rands = array_rand($descriptions, 10);
        $para = [];
        foreach ($rands as $rand) {
            $para[] = $descriptions[$rand];
        }
        $bodyhtml[] = '<p>' . implode(' ', $para) . '</p>';

        // ol 3 dòng
        $bodyhtml[] = '<ol>';

        $rands = array_rand($descriptions, 3);
        foreach ($rands as $rand) {
            $bodyhtml[] = '<li>' . $descriptions[$rand] . '</li>';
        }

        $bodyhtml[] = '</ol>';

        // Blockquote
        $rands = array_rand($descriptions, 2);
        $para = [];
        foreach ($rands as $rand) {
            $para[] = $descriptions[$rand];
        }
        $bodyhtml[] = '<blockquote>' . implode(' ', $para) . '</blockquote>';

        // 1 đoạn 3 câu
        $rands = array_rand($descriptions, 3);
        $para = [];
        foreach ($rands as $rand) {
            $para[] = $descriptions[$rand];
        }
        $bodyhtml[] = '<p>' . implode(' ', $para) . '</p>';
        $bodyhtml = implode("\n", $bodyhtml);

        $values[] = "(
            " . $id . ", " . $catid . ", '" . $catids . "',
            " . $db->quote($titles[$id]) . ",
            " . $db->quote(nv_strtolower(change_alias($titles[$id]))) . ",
            " . $db->quote($description) . ",
            " . $db->quote($bodyhtml) . ", 'img" . random_int(1, 10) . ".jpg', 2,
            " . $db->quote(implode(', ', getKeywrods(10))) . ", 1,
            " . random_int(NV_CURRENTTIME - (10 * 86400), NV_CURRENTTIME) . ", 1, " . random_int(0, 900) . "
        )";
    }

    $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_rows (
        id, catid, catids, title, alias, description, bodyhtml, image, is_thumb, keywords, admin_id, add_time, status, view_hits
    ) VALUES " . implode(', ', $values);
    $db->query($sql);
}
