<!-- BEGIN: addheadbook -->
   <div class="alert alert-info">Bạn đang chọn năm học {INFO.namhoc} {INFO.tuan} từ ngày {INFO.tungay} đến ngày {INFO.denngay}, lớp {INFO.tenlop}, buổi {INFO.buoi} {INFO.thu}, tiết {INFO.tiet}</div>
   <form action="" method="post">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
                <tr>
                    <td>{LANG.unit}</span></td>
                    <td>
                        <input disabled class="form-control w400" type="text" value="{KHOI}" maxlength="255"/>
                    </td>
                </tr>
                <tr class="form-inline">
                    <td>{LANG.subject} <span class="red">*</span></td>
                    <td>
                        <select class="form-control w200" name="mamon" id="subject" onchange="change_subject({KHOI})">
								<option value="0" selected>Chọn Môn</option>

							<!-- BEGIN: loopsubject -->
								<option value="{DATA_SUBJECT.key}" {DATA_SUBJECT.selected}>{DATA_SUBJECT.title}</option>
							<!-- END: loopsubject -->
						</select>
                    </td>
                </tr>

               <tr class="form-inline">
                    <td>{LANG.name_lesson} <span class="red">*</span></td>
                    <td>
                        <select class="form-control w400" name="tenbaihoc" id="name_lesson" onchange="change_name_lesson()">
                            <!-- BEGIN: loopnamelesson -->
								<option value="{DATA_NAMELESSON.key}" {DATA_NAMELESSON.selected}>{DATA_NAMELESSON.title}</option>
							<!-- END: loopnamelesson -->
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>{LANG.lesson_program} <span class="red">*</span></td>
                    <td>
                        <input disabled class="form-control w400" name="tietppct" type="text" value="{DATA.tiet_ppct}" maxlength="255" id="lesson_number"/>
                    </td>
                </tr>

                <tr>
                    <td>{LANG.student_absent}</td>
                    <td>
                        <span style="margin-bottom:20px;">Có phép</span>
                        <select class="form-control w400 selectpicker" name="cophep[]" multiple data-live-search="true">
                                <!-- BEGIN: loopstudentabsentper -->
                                <option value="{DATA_STUDENT_ABSENT_PER.key}" {DATA_STUDENT_ABSENT_PER.selected}>{DATA_STUDENT_ABSENT_PER.title}</option>
                                <!-- END: loopstudentabsentper -->
                        </select>
                        <br></br>
                        <span>Không phép</span>
                        <select class="form-control w400 selectpicker" name="khongphep[]" multiple data-live-search="true">
                                <!-- BEGIN: loopstudentabsentnoper -->
                                <option value="{DATA_STUDENT_ABSENT_NOPER.key}" {DATA_STUDENT_ABSENT_NOPER.selected}>{DATA_STUDENT_ABSENT_NOPER.title}</option>
                                <!-- END: loopstudentabsentnoper -->
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>{LANG.late}</td>
                    <td>
                        <select class="form-control w400 selectpicker" name="dimuon[]" multiple data-live-search="true">
                                <!-- BEGIN: loopstudentlate -->
                                <option value="{DATA_STUDENT_LATE.key}" {DATA_STUDENT_LATE.selected}>{DATA_STUDENT_LATE.title}</option>
                                <!-- END: loopstudentlate -->
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>{LANG.comment}</td>
                    <td>
                    <textarea class="form-control w400" name="nhanxet"  rows="4" cols="50">{DATA.nhan_xet}</textarea>
                    </td>
                </tr>

                <tr class="form-inline">
                    <td>{LANG.mark} <span class="red">*</span></td>
                    <td>
                        {LANG.study}<span class="red">*</span>
                        <input class="form-control w100" name="diemhoctap" type="text" value="{DATA.hoc_tap}" maxlength="255" />
                        {LANG.discipline} <span class="red">*</span>
                        <input class="form-control w100" name="diemkyluat" type="text" value="{DATA.ky_luat}" maxlength="255" />
                        {LANG.clean} <span class="red">*</span>
                        <input class="form-control w100" name="diemvesinh" type="text" value="{DATA.ve_sinh}" maxlength="255" />
                    </td>
                </tr>

                <tr>
                    <td>{LANG.teacher_sign}<span class="red">*</span></td>
                    <td>
                    <input class="form-control w400 pull-left" style="margin-right: 5px" name="giaovienbmkiten" id="anhdaidien" type="text" value="{DATA.ki_ten}" maxlength="255" />
                    <input type="button" class="btn btn-primary" value="Browse server" name="selectimg"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
        </div>
    </form>
    <script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
    <script type="text/javascript">
    
    //<![CDATA[
    var area = "anhdaidien";
    var path = "{NV_UPLOADS_DIR}/{module_name}";
    var currentpath = "{UPLOAD_CURRENT}";
    var type = "image";
    $(document).ready(function() {
    $("input[name=selectimg]").click(function() {
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", "850", "420", "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
    });
    //]]>
    </script>
<!-- END: addheadbook -->