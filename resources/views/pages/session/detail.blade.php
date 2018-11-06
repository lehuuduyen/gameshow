@extends('master')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- #form-Update-Session -->
                <form id="form-Update-Session" method="POST" action="{{ route('session.update', $session->id) }}" >
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin Session</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" value="{{ $session->id }}" name="id" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" class="form-control" value="{{ $session->name }}" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="description" value="{{ $session->description }}" id="description">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
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
                    <h3 class="box-title">Danh sách Question</h3>
                </div>
                <div class="box-body">
                    <button class="btn btn-default" data-toggle="modal" data-target="#modal-AddQuestion">
                        <i class="fa fa-plus"></i> Thêm Question
                    </button>
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
                        <tbody id="content"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Question -->
    <div id="modal-AddQuestion" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <table id="table-AddQuestion" class="table table-bordered table-striped dataTable" style="width: 100%!important;">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        var excludeQuestionIds = [];
        $('#table-Question').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("session.listQuestion", $session->id) }}'
            },
            drawCallback: function (d) {
                var api = this.api();
                var data = api.rows().data();
                excludeQuestionIds = [];
                $.each(data, (key, value) => {
                    excludeQuestionIds.push(value.id);
                });

                $('#table-AddQuestion').DataTable().ajax.reload(null, false);
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
                    },
                    sortable: false
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var urlDetailQuestion = '{{ route('question.show', ':id') }}';
                        urlDetailQuestion = urlDetailQuestion.replace(':id', row.id);
                        return `
                            <a href="${urlDetailQuestion}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Detail</a>
                            <button class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash"></i> Delete</button>
                        `;
                    }
                },
            ]
        });

        $('#table-AddQuestion').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("question.datatable") }}',
                data: (d) => {
                    d.exclude_questions = $.unique(excludeQuestionIds);
                }
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
                        return `
                            <button data-id="${row.id}" class="btn btn-info btn-sm btn-select"><i class="fa fa-plus"></i> Chọn</button>
                        `;
                    }
                },
            ]
        });

        $(document).on("click", ".btn-select", function (e) {
            e.preventDefault();
            var questionId = $(this).data("id");

            $.ajax({
                type: "POST",
                url: '{{ route('session.addQuestion', $session->id) }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "question_id": questionId
                },
                success: function (res) {
                    if(res.success) {
                        $("#table-Question").DataTable().draw( false );
                        $("#table-AddQuestion").DataTable().draw( false );
                    } else {
                        swal("Lỗi", res.message, "error");
                    }
                },
                error: function (res) {
                    console.log(res)
                }
            });
        });

        $(document).on("click", ".btn-delete", function (e) {
            e.preventDefault();
            var data = $("#table-Question").DataTable().row( $(this).parents('tr') ).data();

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
                        url: '{{ route('session.deleteQuestion', $session->id) }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "question_id": data.id
                        },
                        success: function (res) {
                            if(res.success) {
                                $("#table-Question").DataTable().draw( false );
                                $("#table-AddQuestion").DataTable().draw( false );
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

        $( "#table-Question #content" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {

            var order = [];
            $('#table-Question>tbody>tr').each(function(index, element) {
                var data = $("#table-Question").DataTable().row( $(this) ).data();
                order.push({
                    id: data.id,
                    position: index+1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('question.updateOrder', $session->id) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    order: order
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });

        }
    </script>
@endpush