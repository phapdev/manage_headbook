<!-- BEGIN: class -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w100">{LANG.class_id}</th>
                <th>{LANG.class_name}</th>
                <th class="w400">{LANG.home_room_teacher}</th>
                <th class="w100">{LANG.unit}</th>
                <th class="w300 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA_CLASS.ma_lop}</td>
                <td>{DATA_CLASS.ten_lop}</td>
                <td>{DATA_CLASS.ma_gvcn}</td>
                <td>{DATA_CLASS.khoi}</td>
                <td class="text-center">
                    <a href="{DATA_CLASS.url_studentlist}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-list"></i>{LANG.list_student}</a>
                    <a href="{DATA_CLASS.url_edit}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_class({DATA_CLASS.ma_lop}, '{DATA_CLASS.checksess}')"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDCLASS}" class="btn btn-primary">{LANG.add_class}</a>
    </div>
</div>
<!-- END: class -->
