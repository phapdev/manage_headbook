function nv_del_class(ma_lop, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delclass&nocache=' + new Date().getTime(), 'ma_lop=' + ma_lop + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=class';
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_del_student(ma_hoc_sinh, ma_lop, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delstudent&nocache=' + new Date().getTime(), 'ma_hoc_sinh=' + ma_hoc_sinh + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=studentlist&classlistid=' + ma_lop;
			}
		});
	}
}
function nv_del_subject(ma_mon_hoc, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delsubject&nocache=' + new Date().getTime(), 'ma_mon_hoc=' + ma_mon_hoc + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=subject';

			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function change_schoolyear() {
	var manamhoc = $('#schoolyear').val();
	$.ajax({url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=headbook&change_schoolyear=1&manamhoc=' + manamhoc, success: function(result){
		if (result != 'ERR') {
			$("#week").append(result);
		}
  }});
}