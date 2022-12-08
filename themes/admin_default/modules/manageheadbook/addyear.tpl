<!-- BEGIN: addyear -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">

    <form action="" method="post" class="form-inline">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<colgroup>
					<col style="width: 260px" />
					<col/>
				</colgroup>
				<tbody>
                    <tr>
                        <td>{LANG.school_year} <span class="red">*</span></td>
                        <td>
                        <input class="form-control w100" name="tu_nam" value="{DATA.tu_nam}" />
                        <span class="ml-10 mr-10"> - </span>
                        <input class="form-control w100" name="den_nam" value="{DATA.den_nam}" />
                        </td>
                    </tr>
                    <tr>
                        <td>{LANG.start_time} <span class="red">*</span></td>
                        <td>
                            <span class="text-middle">
                                <input class="form-control" name="thoi_gian_bat_dau" id="starttime" value="{DATA.thoi_gian_bat_dau}" style="width: 100px;" maxlength="10" type="text" />
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>{LANG.finish_time} <span class="red">*</span></td>
                        <td>
                            <span class="text-middle">
                                <input class="form-control" name="thoi_gian_ket_thuc" id="finishtime" value="{DATA.thoi_gian_ket_thuc}" style="width: 100px;" maxlength="10" type="text" />
                            </span>
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
    </div>
	</form>
   <script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    $("#starttime,#finishtime").datepicker({
        showOn : "both",
        dateFormat : "dd/mm/yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true,
        buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
        buttonImageOnly : true,
        yearRange: "-10:+10"
    });
</script>
<!-- END: addyear -->
