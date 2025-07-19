@extends('admin.layouts.app')

@section('css')
    <style>
        .modal-lg {
            max-width: 100%;
        }

        #btn-add,
        #btn-add-multiple {
            margin: 0px -10px 20px 15px;
        }

        .btn-group button {
            margin: 0px 4px;
        }

        .icon-big {
            font-size: 2.1em;
        }

        #pwInfo {
            font-style: italic;
            font-size: 12.5px;
        }

        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .swal-text {
            text-align: center !important;
        }

        img[data-toggle="modal"]:hover {
            transform: scale(1.05);
            transition: 0.3s;
        }
    </style>
@endsection

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Kehadiran</h4>
                    </div>

                    <div class="card-body">
                        <button type="button" id="btn-add" class="btn btn-primary btn-md">
                            Absensi
                        </button>
                        <div class="table-responsive">
                            <table id="table-data" class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20px">
                                            <center>No</center>
                                        </th>
                                        <th width="80px">
                                            <center>Tanggal</center>
                                        </th>
                                        <th>
                                            <center>Jam Masuk</center>
                                        </th>
                                        <th>
                                            <center>Jam Keluar</center>
                                        </th>
                                        <th width="30px">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview Gambar">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document" style="width: 80%">
            <div class="modal-content">
                <form id="form-absen" method="post" action="{{ route('admin.internshipMember.absensi.absensi') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-form">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Absensi</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="foto">Foto Absensi</label>
                                    <input type="file" id="foto" name="foto" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" id="keterangan" name="keterangan" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let anggotaIndex = 0;

        $("#btn-add").on("click", function() {
            $('#foto').val(null)
            $('#keterangan').val("")
            $("#modalData").modal("show");
        });

        $("#form-absen").ajaxForm({
            beforeSend: function() {
                formLoading("#form-absen", ".modal-body", true, true);
            },
            success: function(res) {
                dt.ajax.reload(null, false);
                notif("success", "fas fa-check", "Notifikasi Progress", res.message, "done");
                $("#modalData").modal("hide");
            },
            error: function(err, status, message) {
                response = err.responseJSON;
                title = "Notifikasi Error";
                message = (typeof response != "undefined") ? response.message : message;
                if (message == "Error validation") {
                    title = "Error Validasi";
                    $.each(response.data, function(k, v) {
                        message = v[0];
                        return false;
                    });
                }
                notif("danger", "fas fa-exclamation", title, message, "error");
            },
            complete: function() {
                formLoading("#form-absen", ".modal-body", false);
            }
        });

        var dt;
        $(document).ready(function() {
            dt = $("#table-data").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.internshipMember.absensi.scopeData') }}",
                    type: "post"
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: "false",
                        orderable: "false"
                    },
                    {
                        data: "tanggal",
                        name: "tanggal"
                    },
                    {
                        data: "waktu_mulai",
                        name: "waktu_mulai"
                    },
                    {
                        data: "waktu_akhir",
                        name: "waktu_akhir"
                    },
                    {
                        data: "status",
                        name: "status"
                    },
                ],
                ordering: false,
                order: [
                    [0, "asc"]
                ],
            });

            $('body').on('click', 'img[data-toggle="modal"]', function() {
                const imgUrl = $(this).data('img');
                $('#modalImage').attr('src', imgUrl);
            });

            $("#modalData").on("hidden.bs.modal", function() {
                $("#password-form").prop("required", true);
                $("#pwInfo").addClass("hidden");
                if ($("#key-form").val()) $("#form-data .form-control").val("");
            });
        });
    </script>
@endsection
