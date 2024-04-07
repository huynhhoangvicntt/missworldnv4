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
        <th>
          <div class="checkbox">
            <label>
              <input
                type="checkbox"
                name="option[]"
                value="{RESULT.id}"
                onclick="return nv_check_accept_number(this.form,'{VOTING.accept}','{VOTING.errsm}')"
              />
              {RESULT.title}
            </label>
          </div>
        </th>
        <th>
          <div class="clearfix">
            <input
              class="btn btn-success btn-sm"
              type="button"
              value="{VOTING.langsubmit}"
              onclick="nv_sendvoting(this.form, '{VOTING.vid}', '{VOTING.accept}', '{VOTING.checkss}', '{VOTING.errsm}', '{VOTING.active_captcha}');"
            />
            <input
              class="btn btn-primary btn-sm"
              type="button"
              value="{VOTING.langresult}"
              onclick="nv_sendvoting(this.form, '{VOTING.vid}', 0, '{VOTING.checkss}', '', '{VOTING.active_captcha}');"
            />
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      <!-- BEGIN: loop -->
      <tr class="text-center">
        <td class="text-nowrap">{DATA.id}</td>
        <td class="text-nowrap">{DATA.name}</td>
        <td class="text-nowrap">{DATA.birthday}</td>
        <td class="text-nowrap">
          <img src="{DATA.avatar}" style="width: 150px; height: 150px" />
        </td>
      </tr>
      <!-- END: loop -->
    </tbody>
  </table>
</div>
<!-- END: main -->
