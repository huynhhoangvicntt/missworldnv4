/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

// Sử dụng đoạn này nếu có xem chi tiết bài viết trong trình soạn thảo
function fix_detailhtml_image() {
    var news = $('.detail-bodyhtml'), newsW, w, h;
    if (news.length) {
        var newsW = news.innerWidth();
        $.each($('img', news), function() {
            if (typeof $(this).data('width') == "undefined") {
                w = $(this).innerWidth();
                h = $(this).innerHeight();
                $(this).data('width', w);
                $(this).data('height', h);
            } else {
                w = $(this).data('width');
                h = $(this).data('height');
            }

            if (w > newsW) {
                $(this).prop('width', newsW);
                $(this).prop('height', h * newsW / w);
            }
        });
    }
}
$(window).on('load', function() {
    fix_detailhtml_image();
});
$(window).on("resize", function() {
    fix_detailhtml_image();
});
