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
							<td class="text-right">{LANG.schoolyear} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select}</small></td>
							<td>
								<select class="form-control w200" name="schoolyear_{DATA_SCHOOLYEAR.key}">
									<!-- BEGIN: loopschoolyear -->
									<option value="{DATA_SCHOOLYEAR.key}" {DATA_SCHOOLYEAR.selected}>{DATA_SCHOOLYEAR.title}</option>
									<!-- END: loopschoolyear -->
								</select>
							</td>
						</tr>
						<tr>
							<td class="text-right">{LANG.khoi} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select}</small></td>
							<td>
								<select class="form-control w150" name="khoi_{DATA_KHOI.key}">
										<!-- BEGIN: loopkhoi -->
										<option value="{DATA_KHOI.key}" {DATA_KHOI.selected}>{DATA_KHOI.title}</option>
										<!-- END: loopkhoi -->
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
					<th class="w100">{LANG.namhoc}</th>
					<th class="w100">{LANG.khoi}</th>
					<th class="w100">{LANG.subject}</th>
					<th class="w100">{LANG.tiet}</th>
					<th class="w100">{LANG.tenbaihoc}</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td>{DATA.stt}</td>
					<td>{DATA.namhoc}</td>
					<td>{DATA.khoi}</td>
					<td>{DATA.monhoc}</td>
					<td>{DATA.tiet}</td>
					<td>{DATA.tenbaihoc}</td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
	<!-- BEGIN: show -->
</form>
<!-- END: main -->