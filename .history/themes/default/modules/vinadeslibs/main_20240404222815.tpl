<!-- BEGIN: main -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover">
    <colgroup>
      <col class="w100" />
    </colgroup>
    <thead>
      <tr>
        <th style="width: 10%" class="text-nowrap">{LANG.order}</th>
        <th style="width: 15%" class="text-nowrap">{LANG.onecat2_title}</th>
        <th style="width: 40%" class="text-nowrap">{LANG.description}</th>
        <th style="width: 20%" class="text-nowrap">{LANG.onecat2_image}</th>
        <th style="width: 5%" class="text-center text-nowrap">{LANG.status}</th>
        <th style="width: 10%" class="text-center text-nowrap">
          {LANG.function}
        </th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr>
        <td class="text-center">
          <select
            id="change_weight_{ROW.id}"
            onchange="nv_change_onecat2_weight('{ROW.id}', '{NV_CHECK_SESSION}');"
            class="form-control input-sm"
          >
            <!-- BEGIN: weight -->
            <option value="{WEIGHT.w}" {WEIGHT.selected}>{WEIGHT.w}</option>
            <!-- END: weight -->
          </select>
        </td>
        <td>
          <div class="text-nowrap">{ROW.title}</div>
        </td>
        <td>
          <div class="text-nowrap">{ROW.description}</div>
        </td>
        <td>
          <div>
            <img src="{ROW.image}" style="width: 200px; height: 200px" />
          </div>
        </td>
        <td class="text-center">
          <input
            name="status"
            id="change_status{ROW.id}"
            value="1"
            type="checkbox"
            {ROW.status_render}
            onclick="nv_change_onecat2_status('{ROW.id}', '{NV_CHECK_SESSION}');"
          />
        </td>
        <td class="text-center text-nowrap">
          <a class="btn btn-sm btn-default" href="{ROW.url_edit}"
            ><i class="fa fa-edit"></i> {GLANG.edit}</a
          >
          <a
            class="btn btn-sm btn-danger"
            href="javascript:void(0);"
            onclick="nv_delele_onecat2('{ROW.id}', '{NV_CHECK_SESSION}');"
            ><i class="fa fa-trash"></i> {GLANG.delete}</a
          >
        </td>
      </tr>
      <!-- END: loop -->
    </tbody>
  </table>
</div>

<!-- END: main -->
