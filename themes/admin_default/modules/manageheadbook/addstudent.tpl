<!-- BEGIN: addstudent -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">

<div id="edit">
    <!-- BEGIN: error -->
    <div class="alert alert-danger">
        {error}
    </div>
    <!-- END: error -->

    <form action="" method="post">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
                <tr>
                    <td>{LANG.full_name} <span class="red">*</span></td>
                    <td>
                        <input class="form-control w400" name="ho_ten" type="text" value="{DATA.ho_ten}" maxlength="255" />
                    </td>
                </tr>
                <tr class="form-inline">
                    <td>{LANG.birthday} <span class="red">*</span></td>
                    <td>
                        <span class="text-middle">
                            <input class="form-control" name="ngay_sinh" id="dayparty" value="{DATA.ngay_sinh}" style="width: 100px;" maxlength="10" type="text" />
                        </span>
                    </td>
                </tr>
                <tr class="form-inline">
                    <td>{LANG.sex} <span class="red">*</span></td>
                    <td>
                        <select class="form-control w150" name="sex_{DATA_SEX.key}">
                                <!-- BEGIN: loopsex -->
                                <option value="{DATA_SEX.key}" {DATA_SEX.selected}>{DATA_SEX.title}</option>
                                <!-- END: loopsex -->
                        </select>
                    </td>
                </tr>
               <tr class="form-inline">
                    <td>{LANG.class} <span class="red">*</span></td>
                    <td>
                        <select class="form-control w100" name="class_{DATA_CLASS.key}">
                                <!-- BEGIN: loopclass -->
                                <option value="{DATA_CLASS.key}" {DATA_CLASS.selected}>{DATA_CLASS.title}</option>
                                <!-- END: loopclass -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>{LANG.address} <span class="red">*</span></td>
                    <td>
                        <input class="form-control w400" name="dia_chi" type="text" value="{DATA.dia_chi}" maxlength="255" />
                    </td>
                </tr>
                <tr>
                    <td>{LANG.number_absent} <span class="red">*</span></td>
                    <td>
                    <input class="form-control w400" name="so_tiet_nghi" type="text" value="{DATA.so_tiet_nghi}" maxlength="255" />
                    </td>
                </tr>
                <tr>
                    <td>{LANG.avatar} <span class="red">*</span></td>
                    <td>
                    <input class="form-control w400 pull-left" style="margin-right: 5px" name="anh_dai_dien" id="anh_dai_dien" type="text" value="{DATA.anh_dai_dien}" maxlength="255" />
                    <input type="button" class="btn btn-primary" value="Browse server" name="selectimg"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
        </div>
    </form>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    //<![CDATA[
    var area = "anh_dai_dien";
    var path = "{NV_UPLOADS_DIR}/{module_name}";
    var currentpath = "{UPLOAD_CURRENT}";
    var type = "image";
    $("#birthday,#dayinto,#dayparty").datepicker({
        showOn : "both",
        dateFormat : "dd/mm/yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true,
        buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
        buttonImageOnly : true,
        yearRange: "-90:+0"
    });
    $(document).ready(function() {
    $("input[name=selectimg]").click(function() {
        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", "850", "420", "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
        return false;
    });
    });
    //]]>
</script>
<!-- END: addstudent -->
Footer
