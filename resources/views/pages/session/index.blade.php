@extends('master')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- #form-Create-Session -->
                <form action="{{ route('session.store') }}" id="form-Create-Session" method="POST">
                    {{ csrf_field() }}
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm mới Session</h3>
                    </div> <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-left">
                            <button id="refresh" class="btn btn-default"><i class="fa fa-refresh"></i> Làm mới</button>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                        </div>
                    </div>
                </form> <!-- / #form-Create-Session -->

                <!-- #form-Update-Session -->
                <form id="form-Update-Session" style="display: none" method="POST" action="" >
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-header with-border">
                        <h3 class="box-title">Sửa Session</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-success btn-create"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Cập nhật</button>
                        </div>
                    </div>
                </form><!-- / #form-Update-Session -->
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách Session</h3>
                </div>
                <div class="box-body">
                    <table id="table-Session" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <td>Key</td>
                                <td>Tên</td>
                                <td>Mô tả</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- DataTables -->
    <script src="{{ asset('/public/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $('#table-Session').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("session.datatable") }}',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { 
                    data: null, 
                    render: function (data, type, row) {
                        var urlDetail = '{{ route('session.show', ':id') }}';
                        urlDetail = urlDetail.replace(':id', row.id);
                        return `
                            <button class="btn btn-info btn-xs btn-edit"><i class="fa fa-edit"></i> Edit</button>
                            <a href="${urlDetail}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Detail</a>
                        `;
                    }
                },
            ]
        });

        $(document).on("click", ".btn-edit", (function (e) {
            e.preventDefault();
            var row = $(this).closest("tr");
            var data = $('#table-Session').DataTable().row(row).data();

            var action = '{{ route("session.update", ":id") }}';
            action = action.replace(":id", data.id);

            $("#form-Update-Session").attr('action', action);
            $("#name").val(data.name);
            $("#description").val(data.description);

            $("#form-Create-Session").hide("fast");
            $("#form-Update-Session").show("fast");
        }));

        $(document).on("click", ".btn-create", (function (e) {
            e.preventDefault();
            $("#form-Update-Session").hide("fast");
            $("#form-Create-Session").show("fast");
        }));

        $(document).on("click", "#refresh", (function (e) {
            e.preventDefault();
            $("#form-Create-Session input[name=name]").val('');
            $("#form-Create-Session input[name=description]").val('');
        }));
    </script>
@endpush