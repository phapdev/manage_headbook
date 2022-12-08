<!-- BEGIN: headbook -->
    <div class="well">
        <form action="{NV_BASE_ADMINURL}index.php" method="get">
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="manamhoc" id="schoolyear" onchange="change_schoolyear()"">
                          <option value="0" selected>Chọn Năm Học</option>
                          <!-- BEGIN: loopschoolyear -->
                            <option value="{DATA_SCHOOLYEAR.key}" {DATA_SCHOOLYEAR.selected}>{DATA_SCHOOLYEAR.title}</option>
                          <!-- END: loopschoolyear -->
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="matuan" id="week">
                          <option value="0" selected >Chọn Tuần</option>
                          <!-- BEGIN: loopweek -->
                            <option value="{DATA_WEEK.key}" {DATA_WEEK.selected}>{DATA_WEEK.title}</option>
                          <!-- END: loopweek -->
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="malop" id="subject">
                          <option value="0" selected>Chọn Lớp Học</option>
                          <!-- BEGIN: loopclass -->
                            <option value="{DATA_CLASS.key}" {DATA_CLASS.selected}>{DATA_CLASS.title}</option>
                          <!-- END: loopclass -->
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="mabuoi" id="subject">
                          <option value="0" selected>Chọn Buổi</option>
                          <!-- BEGIN: loopdaystatus -->
                            <option value="{DATA_DAYSTUS.key}" {DATA_DAYSTUS.selected}>{DATA_DAYSTUS.title}</option>
                          <!-- END: loopdaystatus -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
              <input class="btn btn-primary" type="submit" value="{LANG.week_display}">
            </div>
        </form>
    </div>
   <div {DISPLAY_INFO} class="alert alert-info">Hiện admin đã khóa tuần {MATUAN}, bạn chỉ có thể xem và xuất file</div>
    <form action="" method="post" class="form-inline" {DISPLAY_FORM}>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
    <tr class="text-center">
      <th rowspan="2" align="center" style="vertical-align:middle; text-align:center;">{LANG.day}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.lesson}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.subject}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.lesson_program}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.name_lesson}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.student_absent}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.late}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.comment}</th>
      <th colspan="3" align="center" style="vertical-align:middle;text-align:center;">{LANG.mark}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.total_point}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;" >{LANG.teacher_sign}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;{DISPLAY_FUNC_TITLE}">{LANG.func}</th>
    </tr>
    <tr>
      <td>{LANG.study}</td>
      <td>{LANG.discipline}</td>
      <td>{LANG.clean}</td>
    </tr>
    <!-- BEGIN: loopday -->
    <!-- BEGIN: looplesson -->
    <tr>
      {DAY}
      <td align="center">{LESSON}
      </td>
      <td>
        {DATA.tenmonhoc}
      </td>
      <td>{DATA.tiet_ppct}</td>
      <td>{DATA.tenbaihoc}</td>
      <td>{DATA.tenhocsinhnghi}</td>
      <td>{DATA.tenhocsinhdimuon}</td>
      <td>{DATA.nhan_xet}</td>
      <td>{DATA.hoc_tap}</td>
      <td>{DATA.ky_luat}</td>
      <td>{DATA.ve_sinh}</td>
      <td>{DATA.tong_diem}</td>
      <td class="text-center">
        <img src="{DATA.ki_ten}" class="content-image" height="38" width="75" style="display:{DISPLAY_IMG}">
        </td>
      <td class="text-center w50" {DISPLAY_FUNC}>
        <a href="{DATA.edit_url}" class="btn btn-default btn-xs"  style="display:{DISPLAY_EDIT}"><i class="fa fa-fw fa-edit"></i></a>
        <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_headbook({DATA.masodaubai}, {MANAMHOC}, {MATUAN}, {MALOP}, {MABUOI}, '{DATA.checksess}')" style="display:{DISPLAY_EDIT}"><i class="fa fa-fw fa-trash"></i></a>
        <a href="{DATA.add_url}" class="btn btn-success btn-xs" style="display:{DISPLAY_ADD}"><i class="fa fa-fw fa-plus"></i></a>
      </td>
    </tr>
    <!-- END: looplesson -->
    <!-- END: loopday -->
  </table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.week_summary}">
        <input class="btn btn-success" type="submit" name="export" value="{LANG.export_headbook}">
    </div>
	</form>
<!-- END: headbook -->