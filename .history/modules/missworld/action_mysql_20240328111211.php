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

// Danh mục một cấp dạng không xem ngoài site
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_onecat1s (
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(190) NOT NULL DEFAULT '' COMMENT 'Tiêu đề',
  description text NOT NULL COMMENT 'Note',
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Dừng, 1: Hoạt động',
  PRIMARY KEY (id),
  KEY weight (weight),
  KEY status (status),
  UNIQUE KEY title (title)
) ENGINE=InnoDB COMMENT 'Bảng danh mục, thể loại, chủ đề... một cấp dạng không xem ngoài site'";

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

// Cấu hình chung trong bảng config
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_text', 'Cấu hình dạng text')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_number', '1000')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_money', '10990000')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_email', 'email@mail.com')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_select1', '2')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_select2', '3')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_select3', '2')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_select4', '2,3')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_checkbox', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_radio', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_mcheckbox', '1,2')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_image', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_textarea', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_textarea_html', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_editor', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_groups', '3,11')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_date', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_fdatet_f', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_fdatet_t', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_dt', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_fdtt_f', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_fdtt_t', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_userid', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_username', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'cfg_newuname', '1')";

// Cấu hình riêng
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (
  config_name varchar(50) NOT NULL COMMENT 'Khóa cấu hình',
  config_value text NOT NULL COMMENT 'Nội dung cấu hình',
  UNIQUE KEY config_name (config_name)
) ENGINE=InnoDB COMMENT 'Bảng cấu hình riêng'";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (config_name, config_value) VALUES
('cfg_text', 'Cấu hình dạng text'),
('cfg_number', '1000'),
('cfg_money', '10990000'),
('cfg_email', 'email@mail.com'),
('cfg_select1', '2'),
('cfg_select2', '3'),
('cfg_select3', '2'),
('cfg_select4', '2,3'),
('cfg_checkbox', '1'),
('cfg_radio', '1'),
('cfg_mcheckbox', '1,2'),
('cfg_image', ''),
('cfg_textarea', ''),
('cfg_textarea_html', ''),
('cfg_editor', ''),
('cfg_groups', '3,11'),
('cfg_date', ''),
('cfg_fdatet_f', ''),
('cfg_fdatet_t', ''),
('cfg_dt', ''),
('cfg_fdtt_f', ''),
('cfg_fdtt_t', ''),
('cfg_userid', '1'),
('cfg_username', '1'),
('cfg_newuname', '1')
";

// Tạo CSDL nếu dùng chức năng bình luận. Nếu không bình luận thì bỏ đoạn này
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'auto_postcomm', '1')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowed_comm', '-1')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'view_comm', '6')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'setcomm', '4')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'activecomm', '1')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'emailcomm', '0')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'adminscomm', '')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'sortcomm', '0')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha_area_comm', '1')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'perpagecomm', '5')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'timeoutcomm', '360')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allowattachcomm', '0')";
$sql_create_module[] = 'INSERT INTO ' . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'alloweditorcomm', '0')";

// Ví dụ cách lập trình đính kèm nhiều ảnh/image
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_multifileimages (
  id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  images text NULL DEFAULT NULL COMMENT 'Nhiều ảnh/file dạng json',
  PRIMARY KEY (id)
) ENGINE=InnoDB COMMENT 'ví dụ cách lập trình đính kèm nhiều ảnh/image'";