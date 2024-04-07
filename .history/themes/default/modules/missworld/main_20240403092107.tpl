<!-- BEGIN: main -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover">
    <colgroup>
      <col class="w100" />
      <col span="1" />
      <col span="2" class="w150" />
    </colgroup>
    <thead>
      <tr class="text-center">
        <th class="text-nowrap">id</th>
        <th class="text-nowrap">Họ tên</th>
        <th class="text-nowrap">Ngày tháng năm sinh</th>
        <th class="text-nowrap">Avatar</th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr class="text-center" method="post">
        <td class="text-nowrap" name="optionid">{DATA.id}</td>
        <td class="text-nowrap">{DATA.name}</td>
        <td class="text-nowrap">{DATA.birthday}</td>
        <td class="text-nowrap">
          <img src="{DATA.avatar}" style="width: 150px; height: 150px" />
        </td>
        <td></td>
        <td>
          <div class="clearfix">
            <input
              class="btn btn-primary btn-sm"
              name="vote"
              type="submit"
              value="{DATA.langsubmit}"
            />
          </div>
        </td>
      </tr>
      <!-- END: loop -->
    </tbody>
  </table>
</div>
<!-- END: main -->
