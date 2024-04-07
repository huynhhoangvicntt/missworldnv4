<!-- BEGIN: main -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover">
    <colgroup>
      <col class="w100" />
    </colgroup>
    <thead>
      <tr>
        <th style="width: 15%" class="text-nowrap">
          {LANG.onecat2_id}Số thứ tự
        </th>
        <th style="width: 15%" class="text-nowrap">
          {LANG.onecat2_title}Họ và tên
        </th>
        <th>Bình chọn</th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr name="vote">
        <td>
          <div class="text-nowrap" name="vote">{ROW.id}</div>
        </td>
        <td>
          <div class="text-nowrap">
            <a href="{ROW.url_view}" title="{ROW.title}">{ROW.title}</a>
          </div>
        </td>
        <td>
          <button type="submit" name="vote">Vote</button>
        </td>
      </tr>
      <!-- END: loop -->
    </tbody>
  </table>
</div>

<!-- END: main -->
