@extends('layouts')

@section('style')
    <link rel="stylesheet" href="{{ asset('') }}assets/css/datatables.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Users</h4>
                    <button type="button" class="btn btn-primary" id="btn-add">
                        Tambah
                    </button>
                    </p>
                    <table class="table" id="example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample">
                        @csrf
                        <input type="hidden" value="" id="user_id">
                        <div class="form-group">
                            <label for="fullName">Nama Lengkap</label>
                            <input type="text" class="form-control" name="fullname" id="fullname"
                                placeholder="Nama Lengkap" value="arifpermadi999">
                        </div>
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                value="arifpermadi999@gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="password">Password </label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password" value="arifpermadi999">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password </label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                placeholder="Konfirmasi Password" value="arifpermadi999">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('') }}assets/js/datatables.min.js"></script>
    <script type="text/javascript">
        $(function() {
            function getData() {

                $.ajax({
                    url: "{{ url('api/users/') }}",
                    method: 'GET',
                    contentType: "application/json; charset=utf-8",
                    headers: {
                        'Authorization': 'bearer ' + window.localStorage.getItem("token")
                    },
                    success: function(response) {
                        $('#example').dataTable({
                            "aaData": response.data,
                            "columns": [{
                                    "data": "id",
                                    render: function(data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart +
                                            1;
                                    }
                                },
                                {
                                    "data": "user_fullname"
                                },
                                {
                                    "data": "user_email"
                                },
                                {
                                    "data": "action",
                                    render: function(data, type, row, meta) {

                                        return "<a href='javascript:void(0)' class='badge badge-info btn-edit' data-id='" +
                                            row.user_id +
                                            "'>Edit</a> <a href='javascript:void(0)' class='badge badge-danger btn-delete' data-id='" +
                                            row.user_id + "'>Hapus</a>";
                                    }
                                },
                            ]
                        })
                        // do something with the response data
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        // handle the error case
                    }
                });
            }

            function redrawDatatable() {
                $('#example').DataTable().clear().destroy();
                getData();
            }
            $("#btn-add").on("click", function() {
                $("#btn-submit").text("Save");
                $('#tambahModal').modal("show");
                $('#tambahModal input').val("");
            });
            $("table").on("click", ".btn-edit", function() {
                $("#btn-submit").text("Update");
                var dataId = $(this).attr("data-id");
                $('#tambahModal').modal("show");
                $('#tambahModal input').val("");
                $.ajax({
                    url: "{{ url('/api/users/show') }}" + "/" + dataId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'bearer ' + window.localStorage.getItem("token")
                    },
                    success: function(response) {
                        $("#user_id").val(response.data.user_id);
                        $("#fullname").val(response.data.user_fullname);
                        $("#email").val(response.data.user_email);
                        $("#password").val("");
                        $("#confirm_password").val("");
                        // do something with the response data
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        // handle the error case
                    }
                });
            })
            $("table").on("click", ".btn-delete", function() {
                var dataId = $(this).attr("data-id");
                var result = confirm("Are you sure want to delete this data?");
                if (result) {
                    $.ajax({
                        url: "{{ url('api/users/delete') }}/" + dataId,
                        method: 'GET',
                        headers: {
                            'Authorization': 'bearer ' + window.localStorage.getItem("token")
                        },
                        success: function(response) {
                            if (!response.success) {
                                swal(
                                    'Error!',
                                    response.message,
                                    'error'
                                  );
                            } else {
                                swal(
                                    'Success!',
                                    response.message,
                                    'success'
                                  );
                                redrawDatatable();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                             swal(
                                'Error!',
                                jqXHR,
                                'error'
                              );
                        }
                    });
                }
            });
            $("#btn-submit").on("click", function() {
                var url = "{{ url('api/users/save') }}";
                var userId = $("#user_id").val();

                if (userId) {
                    url = "{{ url('api/users/update') }}";
                }
                var token = $("input[name='_token']").val();

                var data = {
                    user_id: userId,
                    _token: token,
                    user_fullname: $("#fullname").val(),
                    user_email: $("#email").val(),
                    password: $("#password").val(),
                    password_confirmation: $("#password_confirmation").val()
                };
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    headers: {
                        'Authorization': 'bearer ' + window.localStorage.getItem("token")
                    },
                    success: function(response) {
                        if (!response.success) {
                            swal(
                                'Error!',
                                response.message,
                                'error'
                            );
                        } else {
                            swal(
                                'Success!',
                                response.message,
                                'success'
                              );
                            $('#tambahModal').modal("hide");
                            redrawDatatable();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       swal(
                            'Error!',
                            jqXHR,
                            'error'
                          );
                    }
                });
            })
            getData();
        })
    </script>
@endsection
