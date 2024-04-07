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

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cats";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_onecat1s";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_onecat2s";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";

// Bảng này ví dụ cách lập trình đính kèm nhiều ảnh/image
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_multifileimages";

$sql_create_module = $sql_drop_module;



// Danh mục đa cấp
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cats (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  parentid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'ID cấp trên',
  title varchar(190) NOT NULL COMMENT 'Tiêu đề',
  alias varchar(190) NOT NULL COMMENT 'Liên kết tĩnh không trùng',
  description text NOT NULL COMMENT 'Mô tả ngắn gọn',
  image varchar(255) NOT NULL DEFAULT '' COMMENT 'Ảnh mô tả',
  weight smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Thứ tự trong cùng một cấp',
  sort smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Thứ tự toàn bộ',
  lev smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp mấy, cấp cha thì=0',
  numsubcat smallint(5) NOT NULL DEFAULT '0' COMMENT 'Số item con trong nó',
  subcatid varchar(255) NOT NULL DEFAULT '' COMMENT 'ID item con của nó phân cách bởi dấu phảy',
  keywords text NOT NULL COMMENT 'Từ khóa, phân cách bởi dấu phảy',
  add_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian thêm',
  edit_time int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian sửa',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái 1 bật 0 tắt',
  PRIMARY KEY (id),
  UNIQUE KEY alias (alias),
  KEY parentid (parentid),
  KEY status (status)
) ENGINE=InnoDB COMMENT 'Bảng danh mục, thể loại, chủ đề... đa cấp'";



// Danh mục một cấp dạng có xem ngoài site
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_onecat2s (
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(190) NOT NULL DEFAULT '' COMMENT 'Tiêu đề',
  alias varchar(190) NOT NULL COMMENT 'Liên kết tĩnh không trùng',
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
  UNIQUE KEY alias (alias)
) ENGINE=InnoDB COMMENT 'Bảng danh mục, thể loại, chủ đề... một cấp dạng không xem ngoài site'";