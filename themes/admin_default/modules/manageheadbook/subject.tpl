<!-- BEGIN: subject -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w200">{LANG.subject_id}</th>
                <th class="w200">{LANG.subject_name}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA_CLASS.ma_mon_hoc}</td>
                <td>{DATA_CLASS.ten_mon_hoc}</td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDCLASS}" class="btn btn-primary">{LANG.add_subject}</a>
    </div>
</div>
<!-- END: subject -->

