<!-- BEGIN: subject -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w100">{LANG.subject_id}</th>
                <th class="w100">{LANG.subject_name}</th>
                <th class="w200 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{DATA.ma_mon_hoc}</td>
                <td>{DATA.ten_mon_hoc}</td>
                <td class="text-center">
                    <a href="{DATA.url_edit}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_subject({DATA.ma_mon_hoc}, {DATA.checkss})"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
        <a href="{PAGE_ADDSUBJECT}" class="btn btn-primary">{LANG.add_subject}</a>
    </div>
</div>
<!-- END: subject -->

