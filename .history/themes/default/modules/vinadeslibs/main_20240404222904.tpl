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
      </tr>
      <!-- END: loop -->
    </tbody>
  </table>
</div>

<!-- END: main -->
