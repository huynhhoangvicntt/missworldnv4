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
        <th class="w250 text-center">{LANG.voting_func}</th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr class="text-center">
        <td class="text-nowrap">{DATA.id}</td>
        <td class="text-nowrap">{DATA.name}</td>
        <td class="text-nowrap">{DATA.birthday}</td>
        <td class="text-nowrap">
          <img src="{DATA.avatar}" style="width: 200px; height: auto" />
        </td>
        <td class="text-center">
          <a
            href="#"
            class="btn btn-default btn-xs"
            data-toggle="viewresult"
            data-vid="{DATA.vid}"
            data-checkss="{DATA.checksess}"
            data-title="{LANG.voting_result}"
            >{LANG.voting_result}</a
          >
          <a href="{DATA.url_edit}" class="btn btn-default btn-xs"
            ><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a
          >
          <a
            class="btn btn-danger btn-xs"
            href="javascript:void(0);"
            onclick="nv_del_content({DATA.vid}, '{DATA.checksess}')"
            ><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a
          >
        </td>
      </tr>
      <!-- END: loop -->
    </tbody>
    <tr>
      <td colspan="4">{NV_GENERATE_PAGE}</td>
    </tr>
  </table>
</div>
<!-- END: main -->
