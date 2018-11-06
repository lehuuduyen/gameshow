@extends('master')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- #form-Create-Question -->
                <form action="{{ route('question.store') }}" id="form-Create-Question" method="POST">
                    {{ csrf_field() }}
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm mới Question</h3>
                    </div> <!-- /.box-header -->

                    <div class="box-body">
                        <div class="form-group">
                            <label>Nội dung</label>
                            <input type="text" class="form-control" name="content">
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
                </form> <!-- / #form-Create-Question -->

                <!-- #form-Update-Question -->
                <form id="form-Update-Question" style="display: none" method="POST" action="" >
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-header with-border">
                        <h3 class="box-title">Sửa Question</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Nội dung</label>
                            <input type="text" class="form-control" name="content" id="content">
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
                </form><!-- / #form-Update-Question -->
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách Question</h3>
                </div>
                <div class="box-body">
                    <table id="table-Question" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Tên</td>
                                <td>Mô tả</td>
                                <td>Session</td>
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
        $('#table-Question').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("question.datatable") }}',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'content', name: 'content' },
                { data: 'description', name: 'description' },
                {
                    data: 'sessions',
                    name: 'sessions',
                    render: function (data, type, row) {
                        return data.map(e => e.name).join(', ');
                    }
                },
                { 
                    data: null, 
                    render: function (data, type, row) {
                        var urlDetail = '{{ route('question.show', ':id') }}';
                        urlDetail = urlDetail.replace(':id', data.id);

                        return `
                            <button class="btn btn-info btn-xs btn-edit"><i class="fa fa-edit"></i> Edit</button>
                            <a href="${urlDetail}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Detail</a>
                            <button class="btn btn-danger btn-xs btn-remove"><i class="fa fa-trash"></i> Remove</button>
                        `;
                    }
                },
            ]
        });

        $(document).on("click", ".btn-edit", (function (e) {
            e.preventDefault();
            var row = $(this).closest("tr");
            var data = $('#table-Question').DataTable().row(row).data();

            var action = '{{ route("question.update", ":id") }}';
            action = action.replace(":id", data.id);

            $("#form-Update-Question").attr('action', action);
            $("#content").val(data.content);
            $("#description").val(data.description);

            $("#form-Create-Question").hide("fast");
            $("#form-Update-Question").show("fast");
        }));

        $(document).on("click", ".btn-create", (function (e) {
            e.preventDefault();
            $("#form-Update-Question").hide("fast");
            $("#form-Create-Question").show("fast");
        }));

        $(document).on("click", ".btn-remove", function (e) {
            e.preventDefault();
            var data = $("#table-Question").DataTable().row( $(this).parents('tr') ).data();
            var urlRemove = '{{ route('question.destroy', ':id') }}';
            urlRemove = urlRemove.replace(':id', data.id);

            swal({
                title: "Are you sure?",
                text: `Xoá câu hỏi: ${data.content}!`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        method: "DELETE",
                        url: urlRemove,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            if(res.success) {
                                $("#table-Question").DataTable().draw( false );
                            } else {
                                swal("Lỗi", res.message, "error");
                            }
                        },
                        error: function (res) {
                            console.log(res)
                        }
                    });
                }
            });
        });

        $(document).on("click", "#refresh", (function (e) {
            e.preventDefault();
            $("#form-Create-Question input[name=content]").val('');
            $("#form-Create-Question input[name=description]").val('');
        }));
    </script>
@endpush