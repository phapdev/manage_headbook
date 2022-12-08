<!-- BEGIN: student -->
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w100">{LANG.stt}</th>
                <th>{LANG.full_name}</th>
                <th class="w100">{LANG.birthday}</th>
                <th class="w100">{LANG.sex}</th>
                <th class="w100">{LANG.class}</th>
                <th class="w200">{LANG.address}</th>
                <th class="w100">{LANG.number_absent}</th>
                <th class="w150">{LANG.avatar}</th>
                <th class="w150 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{DATA_STUDENT.stt}</td>
                <td class="text-center">{DATA_STUDENT.ho_ten}</td>
                <td>{DATA_STUDENT.ngay_sinh}</td>
                <td>{DATA_STUDENT.gioi_tinh}</td>
                <td>{DATA_STUDENT.ten_lop}</td>
                <td>{DATA_STUDENT.dia_chi}</td>
                <td>{DATA_STUDENT.so_tiet_nghi}</td>
                <td class="text-center">
                    <img src="{DATA_STUDENT.anh_dai_dien}" class="content-image" height="100" width="75">
                </td>
                <td class="text-center">
                    <a href="{DATA_STUDENT.url_edit}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_student({DATA_STUDENT.ma_hoc_sinh}, {DATA_STUDENT.ma_lop}, '{DATA_STUDENT.checksess}')"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDSTUDENT}" class="btn btn-primary">{LANG.add_student}</a>
</div>
</div>
<!-- END: student -->