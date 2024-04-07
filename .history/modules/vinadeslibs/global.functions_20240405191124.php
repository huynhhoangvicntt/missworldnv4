<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

/**
 * BEGIN code global danh mục đa cấp
 */

// Danh mục đa cấp. Ngoài site chỉ lấy status=1 admin lấy hết
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cats " . (defined('NV_ADMIN') ? '' : ' WHERE status=1') . " ORDER BY sort ASC";
$global_array_cats = $nv_Cache->db($sql, 'id', $module_name);

/**
 * @param integer $id
 * @return array
 * @desc Hàm lấy mảng chứa danh sách id danh mục con của 1 danh mục nào đó, tính cả danh mục đó
 */
function GetCatidInParent($id)
{
    global $global_array_cats;

    $array_cat = [];
    $array_cat[] = $id;
    $subcatid = explode(',', $global_array_cats[$id]['subcatid']);

    if (! empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($global_array_cats[$id]['numsubcat'] == 0) {
                    $array_cat[] = $id;
                } else {
                    $array_cat_temp = GetCatidInParent($id);
                    foreach ($array_cat_temp as $id_i) {
                        $array_cat[] = $id_i;
                    }
                }
            }
        }
    }

    return array_unique($array_cat);
}

/**
 * @param number $parentid
 * @param number $order
 * @param number $lev
 * @return number
 */
function nv_fix_cat_order($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $module_data;

    $sql = "SELECT id, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_cats WHERE parentid=" . $parentid . " ORDER BY weight ASC";
    $result = $db->query($sql);
    $array_cat_order = [];
    while ($row = $result->fetch()) {
        $array_cat_order[] = $row['id'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_cat_order as $id_i) {
        ++$order;
        ++$weight;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cats SET weight=" . $weight . ", sort=" . $order . ", lev=" . $lev . " WHERE id=" . intval($id_i);
        $db->query($sql);
        $order = nv_fix_cat_order($id_i, $order, $lev);
    }
    $numsubcat = $weight;
    if ($parentid > 0) {
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cats SET numsubcat=" . $numsubcat;
        if ($numsubcat == 0) {
            $sql .= ", subcatid=''";
        } else {
            $sql .= ", subcatid='" . implode(',', $array_cat_order) . "'";
        }
        $sql .= " WHERE id=" . intval($parentid);
        $db->query($sql);
    }
    return $order;
}

/**
 * END code global danh mục đa cấp
 */

/**
 * BEGIN code danh mục một cấp dạng 1
 */
// Danh mục
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_onecat2s ORDER BY weight ASC";
$global_array_onecat2s = $nv_Cache->db($sql, 'id', $module_name);

/**
 * END code danh mục một cấp dạng 1
 */