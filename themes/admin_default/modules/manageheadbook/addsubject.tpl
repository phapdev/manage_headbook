<!-- BEGIN: addsubject -->
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
                    <td>{LANG.subject} <span class="red">*</span></td>
                    <td>
                        <input class="form-control w400" name="ten_mon_hoc" type="text" value="{DATA.ten_mon_hoc}" maxlength="255" />
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
        </div>
    </form>
</div>
<!-- END: addsubject -->