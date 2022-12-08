<!-- BEGIN: schoolyearlist -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w200">{LANG.school_year}</th>
                <th>{LANG.start_time}</th>
                <th>{LANG.finish_time}</th>
                <th class="w300 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{DATA.nam_hoc}</td>
                <td>{DATA.thoi_gian_bat_dau}</td>
                <td>{DATA.thoi_gian_ket_thuc}</td>
                <td class="text-center">
                    <a href="{DATA.url_week_list}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-list"></i>{LANG.week_list}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_schoolyear({DATA.ma_nam_hoc}, '{DATA.checksess}')"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDSCHOOLYEAR}" class="btn btn-primary">{LANG.add}</a>
    </div>
</div>
<!-- END: schoolyearlist -->