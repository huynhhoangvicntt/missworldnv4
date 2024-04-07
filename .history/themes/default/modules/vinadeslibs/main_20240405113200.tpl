<!-- BEGIN: main -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover">
    <colgroup>
      <col class="w100" />
    </colgroup>
    <thead>
      <tr>
        <th style="width: 1%" class="text-center">
          <input
            name="check_all[]"
            type="checkbox"
            value="yes"
            onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"
          />
        </th>
        <th style="width: 15%" class="text-nowrap">
          {LANG.onecat2_title}Họ và tên
        </th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr>
        <td class="text-center">
          <input
            type="checkbox"
            onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);"
            value="{ROW.id}"
            name="idcheck[]"
          />
        </td>
        <td>
          <div class="text-nowrap">{ROW.title}</div>
        </td>
      </tr>
      <!-- END: loop -->
    </tbody>
  </table>
</div>

<!-- END: main -->
