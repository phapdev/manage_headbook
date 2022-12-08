<!-- BEGIN: weeklist -->
   <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">{LANG.week_name}</th>
                <th class="text-center">{LANG.from_day}</th>
                <th class="text-center">{LANG.to_day}</th>
                <th class="text-center">{LANG.school_year}</th>
                <th class="w250 text-center">{LANG.desc}</th>
                <th class="text-center">{LANG.validate}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class=text-center>{DATA.ten_tuan}</td>
                <td class=text-center>{DATA.tu_ngay}</td>
                <td class=text-center>{DATA.den_ngay}</td>
                <td class=text-center>{DATA.nam_hoc}</td>
                <td class=text-center>
                     {DATA.mo_ta}
                    <a href="{DATA.url_edit}" class="btn btn-default btn-xs" ><i class="fa fa-fw fa-{DATA.icon}"></i></a>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="activecheckbox" id="change_active_week_{DATA.matuan}" onclick="nv_change_active_week1('{DATA.matuan}')" {DATA.active}>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
  <script>
    function nv_change_active_week1(matuan) {
	var new_status = $('#change_active_week_'+matuan).is(':checked') ? 1 : 0;
	if (confirm(nv_is_change_act_confirm[0])) {
			nv_settimeout_disable('change_active_week_'+matuan, 3000);
			$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_active&nocache=' + new Date().getTime(), 'change_active=1&matuan=' + matuan + '&new_status=' + new_status, function(res) {
				if(res == 'OK') {
					alert('Mở/khóa tuần thành công !!!');

				} else {
					alert(res);
					$('#change_active_week_'+matuan).prop('checked', new_status == 1 ? 'true' : 'false');

				}
			});
	} else {
		$('#change_active_week_'+matuan).prop('checked', new_status == 1 ? 'true' : 'false');

	}
}
  </script>
<!-- END: weeklist -->
