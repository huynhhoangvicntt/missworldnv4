<!-- BEGIN: main -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover">
    <caption>
      Danh sách thí sinh
    </caption>
    <colgroup>
      <col class="w100" />
    </colgroup>
    <thead>
      <tr>
        <th style="width: 15%" class="text-nowrap">{LANG.onecat2_title}</th>
        <th style="width: 40%" class="text-nowrap">{LANG.description}</th>
        <th style="width: 20%" class="text-nowrap">{LANG.onecat2_image}</th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr>
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
