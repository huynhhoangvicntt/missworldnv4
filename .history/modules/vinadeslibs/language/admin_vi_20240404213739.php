<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '04/03/2010, 15:22';
$lang_translator['copyright'] = '@Copyright (C) 2009-2021 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

// Lang chung. Giữ lại trên tất cả các module
$lang_module['add'] = 'Thêm';
$lang_module['title'] = 'Tiêu đề';
$lang_module['alias'] = 'Liên kết tĩnh';
$lang_module['errorsave'] = 'Vì một lý do nào đó mà dữ liệu không thể lưu lại được';
$lang_module['function'] = 'Chức năng';
$lang_module['order'] = 'Thứ tự';
$lang_module['status'] = 'Hoạt động';
$lang_module['status1'] = 'Kích hoạt';
$lang_module['keywords'] = 'Từ khóa';
$lang_module['search_keywords'] = 'Từ khóa tìm kiếm';
$lang_module['description'] = 'Thông tin chi tiết';
$lang_module['illustrating_images'] = 'Ảnh minh họa';
$lang_module['note'] = 'Chú ý';
$lang_module['enter_search_key'] = 'Nhập từ khóa';
$lang_module['select2_pick'] = 'Nhập từ khóa để tìm và chọn';
$lang_module['addtime'] = 'Tạo lúc';
$lang_module['edittime'] = 'Cập nhật lúc';
$lang_module['approval'] = 'Duyệt bài đăng';
$lang_module['msgnocheck'] = 'Vui lòng chọn ít nhất một dòng để thực hiện';
$lang_module['to'] = 'đến';
$lang_module['from_day'] = 'Từ ngày';
$lang_module['to_day'] = 'Đến ngày';
$lang_module['is_required'] = 'là mục bắt buộc';

// Lang phần danh sách main
$lang_module['main'] = 'Danh sách bài đăng';
$lang_module['main_add'] = 'Thêm bài';
$lang_module['main_edit'] = 'Sửa bài viết';
$lang_module['main_cat'] = 'Thuộc danh mục';
$lang_module['main_cat1'] = 'Danh mục';
$lang_module['main_cat2'] = 'Danh mục chính';
$lang_module['main_bodyhtml'] = 'Nội dung bài viết';
$lang_module['main_error_catids'] = 'Chưa chọn danh mục';
$lang_module['main_error_catid'] = 'Chưa chọn danh mục chính';
$lang_module['main_error_title'] = 'Chưa nhập tiêu đề';
$lang_module['main_error_exists'] = 'Liên kết tĩnh bị trùng, mời nhập giá trị khác';
$lang_module['main_error_bodyhtml'] = 'Chưa nhập nội dung bài viết';

// Lang chức năng danh mục đa cấp
$lang_module['cat'] = 'Danh mục';
$lang_module['cat_manager'] = 'Danh mục đa cấp';
$lang_module['cat_title'] = 'Tên danh mục';
$lang_module['cat_add'] = 'Thêm danh mục';
$lang_module['cat_edit'] = 'Sửa danh mục';
$lang_module['cat_error_title'] = 'Tiêu đề không được để trống';
$lang_module['cat_error_exists'] = 'Liên kết tĩnh bị trùng, vui lòng nhập giá trị khác';
$lang_module['cat_sub_sl'] = 'Là danh mục chính';
$lang_module['cat_parentid'] = 'Thuộc danh mục';
$lang_module['cat_parent'] = 'Danh mục chính';

// Lang chức năng danh mục 1 cấp loại 1
$lang_module['onecat1'] = 'Danh mục';
$lang_module['onecat1_manager'] = 'Danh mục 1 cấp 1';
$lang_module['onecat1_title'] = 'Tên danh mục';
$lang_module['onecat1_description'] = 'Giới thiệu';
$lang_module['onecat1_add'] = 'Thêm danh mục';
$lang_module['onecat1_edit'] = 'Sửa danh mục';
$lang_module['onecat1_error_title'] = 'Tiêu đề không được để trống';
$lang_module['onecat1_error_exists'] = 'Tiêu đề bị trùng';

// Lang chức năng danh mục 1 cấp loại 2
$lang_module['onecat2'] = 'Danh mục';
$lang_module['onecat2_manager'] = 'Danh mục 1 cấp 2';
$lang_module['onecat2_title'] = 'Tên thí sinh';
$lang_module['onecat2_image'] = 'Avatar';
$lang_module['onecat2_description'] = 'Giới thiệu';
$lang_module['onecat2_add'] = 'Thêm danh mục';
$lang_module['onecat2_edit'] = 'Sửa danh mục';
$lang_module['onecat2_error_title'] = 'Tiêu đề không được để trống';
$lang_module['onecat2_error_exists'] = 'Liên kết tĩnh bị trùng, vui lòng nhập giá trị khác';

// Lang cho phần cấu hình chung
$lang_module['config1'] = 'Cấu hình chung';
$lang_module['config1_cfg_text'] = 'Text thường';
$lang_module['config1_cfg_number'] = 'Số nguyên';
$lang_module['config1_cfg_money'] = 'Số tiền';
$lang_module['config1_cfg_money_unit'] = 'đ';
$lang_module['config1_cfg_email'] = 'Email';
$lang_module['config1_cfg_select1'] = 'Select vòng for';
$lang_module['config1_cfg_select11'] = 'Chọn 1';
$lang_module['config1_cfg_select12'] = 'Chọn 2';
$lang_module['config1_cfg_select13'] = 'Chọn 3';
$lang_module['config1_cfg_select14'] = 'Chọn 4';
$lang_module['config1_cfg_select15'] = 'Chọn 5';
$lang_module['config1_cfg_select2'] = 'Select CSDL';
$lang_module['config1_cfg_select3'] = 'Select ajax';
$lang_module['config1_cfg_select4'] = 'Multi select ajax';
$lang_module['config1_cfg_checkbox'] = 'Checkbox dạng đơn';
$lang_module['config1_cfg_mcheckbox'] = 'Checkbox multi';
$lang_module['config1_cfg_mcheckbox1'] = 'Check 1';
$lang_module['config1_cfg_mcheckbox2'] = 'Check 2';
$lang_module['config1_cfg_mcheckbox3'] = 'Check 3';
$lang_module['config1_cfg_mcheckbox4'] = 'Check 4';
$lang_module['config1_cfg_mcheckbox5'] = 'Check 5';
$lang_module['config1_cfg_radio'] = 'Radio';
$lang_module['config1_cfg_radio1'] = 'Radio 1';
$lang_module['config1_cfg_radio2'] = 'Radio 2';
$lang_module['config1_cfg_radio3'] = 'Radio 3';
$lang_module['config1_cfg_image'] = 'Chọn ảnh';
$lang_module['config1_cfg_textarea'] = 'Textarea thường';
$lang_module['config1_cfg_textarea_html'] = 'Textarea cho phép HTML';
$lang_module['config1_cfg_editor'] = 'Trình soạn thảo';
$lang_module['config1_cfg_groups'] = 'Phân quyền nhóm';
$lang_module['config1_cfg_date'] = 'Ngày tháng';
$lang_module['config1_cfg_date_error'] = 'Ngày tháng không đúng định dạng';
$lang_module['config1_cfg_fdatet'] = 'Ngày tháng từ đến';
$lang_module['config1_cfg_fdatet_error'] = 'Từ ngày phải nhỏ hơn hoặc bằng đến ngày';
$lang_module['config1_cfg_fdatet_f_error'] = 'Ngày tháng không đúng định dạng tại ô từ ngày';
$lang_module['config1_cfg_fdatet_t_error'] = 'Ngày tháng không đúng định dạng tại ô đến ngày';
$lang_module['config1_cfg_dt'] = 'Ngày giờ';
$lang_module['config1_cfg_dt_error'] = 'Ngày giờ không đúng định dạng';
$lang_module['config1_cfg_fdtt'] = 'Ngày giờ từ đến';
$lang_module['config1_cfg_fdtt_error'] = 'Ngày giờ từ phải nhỏ hơn ngày giờ đến';
$lang_module['config1_cfg_fdtt_f_error'] = 'Ngày giờ không đúng định dạng tại ô từ ngày';
$lang_module['config1_cfg_fdtt_t_error'] = 'Ngày giờ không đúng định dạng tại ô đến ngày';
$lang_module['config1_cfg_userid'] = 'Chọn userid';
$lang_module['config1_cfg_userid_error'] = 'Thành viên không tồn tại';
$lang_module['config1_cfg_username'] = 'Chọn username';
$lang_module['config1_cfg_username_error'] = 'Thành viên không tồn tại';
$lang_module['config1_cfg_newuname'] = 'Chọn username mới';
$lang_module['config1_cfg_newuname_error'] = 'Thành viên không tồn tại';

// Lang cho phần cấu hình riêng
$lang_module['config2'] = 'Cấu hình riêng';
$lang_module['config2_cfg_text'] = 'Text thường';
$lang_module['config2_cfg_number'] = 'Số nguyên';
$lang_module['config2_cfg_money'] = 'Số tiền';
$lang_module['config2_cfg_money_unit'] = 'đ';
$lang_module['config2_cfg_email'] = 'Email';
$lang_module['config2_cfg_select1'] = 'Select vòng for';
$lang_module['config2_cfg_select11'] = 'Chọn 1';
$lang_module['config2_cfg_select12'] = 'Chọn 2';
$lang_module['config2_cfg_select13'] = 'Chọn 3';
$lang_module['config2_cfg_select14'] = 'Chọn 4';
$lang_module['config2_cfg_select15'] = 'Chọn 5';
$lang_module['config2_cfg_select2'] = 'Select CSDL';
$lang_module['config2_cfg_select3'] = 'Select ajax';
$lang_module['config2_cfg_select4'] = 'Multi select ajax';
$lang_module['config2_cfg_checkbox'] = 'Checkbox dạng đơn';
$lang_module['config2_cfg_mcheckbox'] = 'Checkbox multi';
$lang_module['config2_cfg_mcheckbox1'] = 'Check 1';
$lang_module['config2_cfg_mcheckbox2'] = 'Check 2';
$lang_module['config2_cfg_mcheckbox3'] = 'Check 3';
$lang_module['config2_cfg_mcheckbox4'] = 'Check 4';
$lang_module['config2_cfg_mcheckbox5'] = 'Check 5';
$lang_module['config2_cfg_radio'] = 'Radio';
$lang_module['config2_cfg_radio1'] = 'Radio 1';
$lang_module['config2_cfg_radio2'] = 'Radio 2';
$lang_module['config2_cfg_radio3'] = 'Radio 3';
$lang_module['config2_cfg_image'] = 'Chọn ảnh';
$lang_module['config2_cfg_textarea'] = 'Textarea thường';
$lang_module['config2_cfg_textarea_html'] = 'Textarea cho phép HTML';
$lang_module['config2_cfg_editor'] = 'Trình soạn thảo';
$lang_module['config2_cfg_groups'] = 'Phân quyền nhóm';
$lang_module['config2_cfg_date'] = 'Ngày tháng';
$lang_module['config2_cfg_date_error'] = 'Ngày tháng không đúng định dạng';
$lang_module['config2_cfg_fdatet'] = 'Ngày tháng từ đến';
$lang_module['config2_cfg_fdatet_error'] = 'Từ ngày phải nhỏ hơn hoặc bằng đến ngày';
$lang_module['config2_cfg_fdatet_f_error'] = 'Ngày tháng không đúng định dạng tại ô từ ngày';
$lang_module['config2_cfg_fdatet_t_error'] = 'Ngày tháng không đúng định dạng tại ô đến ngày';
$lang_module['config2_cfg_dt'] = 'Ngày giờ';
$lang_module['config2_cfg_dt_error'] = 'Ngày giờ không đúng định dạng';
$lang_module['config2_cfg_fdtt'] = 'Ngày giờ từ đến';
$lang_module['config2_cfg_fdtt_error'] = 'Ngày giờ từ phải nhỏ hơn ngày giờ đến';
$lang_module['config2_cfg_fdtt_f_error'] = 'Ngày giờ không đúng định dạng tại ô từ ngày';
$lang_module['config2_cfg_fdtt_t_error'] = 'Ngày giờ không đúng định dạng tại ô đến ngày';
$lang_module['config2_cfg_userid'] = 'Chọn userid';
$lang_module['config2_cfg_userid_error'] = 'Thành viên không tồn tại';
$lang_module['config2_cfg_username'] = 'Chọn username';
$lang_module['config2_cfg_username_error'] = 'Thành viên không tồn tại';
$lang_module['config2_cfg_newuname'] = 'Chọn username mới';
$lang_module['config2_cfg_newuname_error'] = 'Thành viên không tồn tại';

// Ngôn ngữ thông tin module tại trang main quản trị
$lang_module['siteinfo_posts'] = 'Tổng số bài viết';
$lang_module['siteinfo_pendinginfo'] = 'Đây là ví dụ về công việc cần xử lý';

// Ngôn ngữ phần ví dụ thông báo
$lang_module['notify'] = 'Thông báo hệ thống';
$lang_module['notify_random'] = 'Bài viết gợi ý <strong>%s</strong>';

// Ngôn ngữ phần ví dụ nhập/xuất excel
$lang_module['excel'] = 'Nhập/xuất excel';
$lang_module['excel_download_template'] = 'Tải mẫu';
$lang_module['excel_note_template'] = 'Nhấp nút bên dưới để tải về mẫu excel, nhập liệu đúng theo mẫu đó. Yêu cầu không được thêm bớt, thay đổi thứ tự các cột';
$lang_module['excel_export'] = 'Xuất excel';
$lang_module['excel_import'] = 'Nhập excel';
$lang_module['excel_error_nofile'] = 'Chưa chọn file excel';
$lang_module['import_error_readexcel'] = 'Không thể đọc file, kiểm tra lại định dạng excel';

// Ngôn ngữ phần ví dụ xuất PDF
$lang_module['pdf'] = 'Xuất PDF';

// Ngôn ngữ phần nhiều ảnh/file
$lang_module['multifileimage'] = 'Nhiều ảnh/File';