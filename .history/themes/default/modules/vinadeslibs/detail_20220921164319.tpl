<!-- BEGIN: main -->
<div class="module-name-{MODULE_NAME} module-file-{MODULE_FILE} op-{OP}">
    <div class="item-detail margin-bottom-lg">
        <h1 class="margin-bottom">{ROW.title}</h1>
        <ul class="meta text-muted small margin-bottom-lg">
            <li><i class="fa fa-clock-o"></i> {ROW.add_time}</li>
            <li><i class="fa fa-eye"></i> {ROW.view_hits}</li>
            <li><i class="fa fa-comment-o"></i> {ROW.comment_hits}</li>
        </ul>
        <!-- BEGIN: description -->
        <div class="detail-summary margin-bottom">
            {ROW.description}
        </div>
        <!-- END: description -->
        <div class="detail-html detail-bodyhtml">
            {ROW.bodyhtml}
        </div>
    </div>
    <!-- BEGIN: comment -->
    <hr class="space-comment"/>
    {ROW.comment_content}
    <!-- END: comment -->
    <!-- BEGIN: new -->
    <hr class="space-new"/>
    <div class="item-detail-other item-detail-new">
        <div class="head h2">{LANG.detail_other_new}</div>
        <div class="items">
            <!-- BEGIN: loop -->
            <div class="item">
                <a class="img" href="{ITEM.link}" style="background-image: url('{ITEM.thumb}');"><img alt="{ITEM.title}" src="{ITEM.thumb}" class="hidden"></a>
                <a class="h3" href="{ITEM.link}">{ITEM.title}</a>
            </div>
            <!-- END: loop -->
        </div>
    </div>
    <!-- END: new -->
    <!-- BEGIN: old -->
    <hr class="space-old"/>
    <div class="item-detail-other item-detail-old">
        <div class="head h2">{LANG.detail_other_old}</div>
        <div class="items">
            <!-- BEGIN: loop -->
            <div class="item">
                <a class="img" href="{ITEM.link}" style="background-image: url('{ITEM.thumb}');"><img alt="{ITEM.title}" src="{ITEM.thumb}" class="hidden"></a>
                <a class="h3" href="{ITEM.link}">{ITEM.title}</a>
            </div>
            <!-- END: loop -->
        </div>
    </div>
    <!-- END: old -->
</div>
<script type="application/ld+json">{ROW.structured_data}</script>
<!-- END: main -->
