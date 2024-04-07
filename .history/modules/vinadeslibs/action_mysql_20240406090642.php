<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_onecat2s";


$sql_create_module = $sql_drop_module;
// Danh sách đối tượng chính cần quản lý
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
  id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  catid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'ID danh mục chính',
  catids varchar(190) NOT NULL COMMENT 'ID các danh mục',
  title varchar(190) NOT NULL COMMENT 'Tiêu đề',
  alias varchar(190) NOT NULL COMMENT 'Liên kết tĩnh không trùng',
  description text NOT NULL COMMENT 'Mô tả ngắn gọn',
  bodyhtml longtext NOT NULL COMMENT 'Chi tiết',
  image varchar(255) NOT NULL DEFAULT '' COMMENT 'Ảnh mô tả',
  is_thumb tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 là không có ảnh, 1 ảnh asset, 2 ảnh upload 3 ảnh remote',
  keywords text NOT NULL COMMENT 'Từ khóa, phân cách bởi dấu phảy',
  admin_id int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'ID người đăng',
  add_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian thêm',
  edit_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian sửa',
  view_hits int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Số lượt xem',
  comment_hits int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Số bình luận',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái 1 bật 0 tắt',
  PRIMARY KEY (id),
  KEY catid (catid),
  KEY catids (catids),
  KEY title (title),
  UNIQUE KEY alias1 (alias),
  KEY alias2 (alias),
  KEY add_time (add_time),
  KEY edit_time (edit_time),
  KEY admin_id (admin_id),
  KEY status (status)
) ENGINE=InnoDB COMMENT 'Bảng danh sách đối tượng chính cần quản lý'";

// Danh mục một cấp dạng có xem ngoài site
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_onecat2s (
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(190) NOT NULL DEFAULT '' COMMENT 'Tiêu đề',
  image varchar(255) NOT NULL DEFAULT '' COMMENT 'Ảnh mô tả',
  keywords text NOT NULL COMMENT 'Từ khóa, phân cách bởi dấu phảy',
  description text NOT NULL COMMENT 'Note',
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Dừng, 1: Hoạt động',
  PRIMARY KEY (id),
  KEY weight (weight),
  KEY status (status),
) ENGINE=InnoDB COMMENT 'Bảng danh mục, thể loại, chủ đề... một cấp dạng không xem ngoài site'";