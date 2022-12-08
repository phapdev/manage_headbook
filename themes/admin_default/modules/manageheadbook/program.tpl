<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">
	{ERROR}
</div>
<!-- END: error -->
<!-- BEGIN: success -->
<div class="alert alert-success">
	{SUCCESS}
</div>
<!-- END: success -->
<form action="{FORM_ACTION}" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-24 col-md-24">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<tbody>
						<tr>
							<td class="text-right">{LANG.school_year} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select}</small></td>
							<td>
								<select class="form-control w200" name="school_year_{DATA_SCHOOL_YEAR.key}">
									<!-- BEGIN: loopschool_year -->
									<option value="{DATA_SCHOOL_YEAR.key}" {DATA_SCHOOL_YEAR.selected}>{DATA_SCHOOL_YEAR.title}</option>
									<!-- END: loopschool_year -->
								</select>
							</td>
						</tr>
						<tr>
							<td class="text-right">{LANG.grade} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select}</small></td>
							<td>
								<select class="form-control w150" name="grade_{DATA_GRADE.key}">
										<!-- BEGIN: loopgrade -->
										<option value="{DATA_GRADE.key}" {DATA_GRADE.selected}>{DATA_GRADE.title}</option>
										<!-- END: loopgrade -->
								</select>
							</td>
						</tr>
						<tr>
							<td class="text-right">{LANG.subject} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select}</small></td>
							<td>
								<select class="form-control w200" name="subject_{DATA_SUBJECT.key}">
									<!-- BEGIN: loopsubject -->
									<option value="{DATA_SUBJECT.key}" {DATA_SUBJECT.selected}>{DATA_SUBJECT.title}</option>
									<!-- END: loopsubject -->
								</select>
							</td>
						</tr>						
						<tr>
							<td class="text-right">{LANG.upload_file_excel} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select_correct_file} <a href="#">{LANG.here}</a></small></td>
							<td><input class="w300 form-control pull-left" type="file" name="ufile" id="ufile"/></td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td>
								<input type="submit" value="{LANG.import}" name="do" class="btn btn-success"/>								
								<input type="submit" value="{LANG.show_program}" name="show" class="btn btn-info"/>
								<input type="submit" value="{LANG.show_all}" name="showall" class="btn btn-info"/>
								<input type="submit" value="{LANG.del_program}" name="del" class="btn btn-danger"></input>
								<input type="submit" value="{LANG.del_all}" name="delall" class="btn btn-danger"></input>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- BEGIN: show -->
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="w100">{LANG.stt}</th>
					<th class="w100">{LANG.school_year}</th>
					<th class="w100">{LANG.grade}</th>
					<th class="w100">{LANG.subject}</th>
					<th class="w100">{LANG.tiet}</th>
					<th class="w100">{LANG.lesson}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td>{DATA.stt}</td>
					<td>{DATA.nam_hoc}</td>
					<td>{DATA.grade}</td>
					<td>{DATA.mon_hoc}</td>
					<td>{DATA.tiet}</td>
					<td>{DATA.lesson}</td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
	<!-- BEGIN: show -->
</form>
<!-- END: main -->