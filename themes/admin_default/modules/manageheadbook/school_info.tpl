<!-- BEGIN: school_info -->
	<form action="" method="post" class="form-inline">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<colgroup>
					<col style="width: 260px" />
					<col/>
				</colgroup>
				<tbody>
                    <tr>
						<td>{LANG.department_name} <span class="red">*</span></td>
						<td><input class="form-control w400" name="ten_so" value="{DATA.ten_so}" /></td>
					</tr>
                    <tr>
						<td>{LANG.room_name} <span class="red">*</span></td>
						<td><input class="form-control w400" name="ten_phong" value="{DATA.ten_phong}" /></td>
					</tr>
					<tr>
						<td>{LANG.school_name} <span class="red">*</span></td>
						<td><input class="form-control w400" name="ten_truong" value="{DATA.ten_truong}" /></td>
					</tr>
                     <tr>
						<td>{LANG.school_year} <span class="red">*</span></td>
						<td>
                        <input class="form-control w100" name="tu_nam" value="{DATA.tu_nam}" />
                        <span class="ml-10 mr-10"> - </span>
                        <input class="form-control w100" name="den_nam" value="{DATA.den_nam}" />
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
    </div>
	</form>
<!-- END: school_info -->
