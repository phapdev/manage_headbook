<!-- BEGIN: addclass -->
    <form action="" method="post" class="form-inline">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<colgroup>
					<col style="width: 260px" />
					<col/>
				</colgroup>
				<tbody>
                    <tr>
						<td>{LANG.class_name} <span class="red">*</span></td>
						<td><input class="form-control w400" name="ten_lop" value="{CLASS.ten_lop}"/></td>
					</tr>
                    <tr>
                        <td>{LANG.home_room_teacher} <span class="red">*</span></td>
                        <td>
                            <select class="form-control w200" name="ma_gvcn">
                                    <option value="0" {DATA.selected}>{LANG.choose_teacher}</option>
                                    <!-- BEGIN: loop -->
                                    <option value="{DATA.key}" {DATA.selected}>{DATA.title}</option>
                                    <!-- END: loop -->
                            </select>
                        </td>
                    </tr>
					<tr>
						<td>{LANG.unit} <span class="red">*</span></td>
						<td><input class="form-control w400" name="khoi" value="{CLASS.khoi}"/></td>
					</tr>
				</tbody>
			</table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{GLANG.save}">
    </div>
<!-- END: addclass -->