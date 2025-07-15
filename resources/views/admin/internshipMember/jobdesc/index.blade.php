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
                        <h4 class="card-title">Jobdesc & Aktifitas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-data" class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20px">
                                            <center>No</center>
                                        </th>
                                        <th width="50%">Deskripsi Pekerjaan</th>
                                        <th>
                                            <center>Mulai Dikerjakan</center>
                                        </th>
                                        <th>
                                            <center>Selesai Dikerjakan</center>
                                        </th>
                                        <th width="30px">Status</th>
                                        <th width="80px">
                                            <center>Aksi</center>
                                        </th>
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
                <form id="form-proses" method="post" action="{{ route('admin.internshipMember.jobdesc.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-form">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Jobdesc</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="assign_to">Ditugaskan Kepada</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="namaSerti">Pekerjaan</label>
                                    <textarea class="form-control" name="pekerjaan" id="pekerjaan"></textarea>
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

    <div class="modal fade" id="modalKerjakan" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document" style="width: 80%">
            <div class="modal-content">
                <form id="form-kerjakan" method="post" action="{{ route('admin.internshipMember.jobdesc.kerjakan') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-pengerjaan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Jobdesc</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="namaSerti">Detail Pekerjaan</label>
                                    <textarea class="form-control" name="detail_pekerjaan" id="detail_pekerjaan" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gambar_awal">Foto Mulai Pengerjaan</label>
                                    <input type="file" name="gambar_awal" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">kembali</button>
                        <button type="submit" class="btn btn-primary btn-md">Mulai Kerjakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSelesaikan" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document" style="width: 80%">
            <div class="modal-content">
                <form id="form-selesaikan" method="post"
                    action="{{ route('admin.internshipMember.jobdesc.selesaikan') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-selesaikan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Jobdesc</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detail_pekerjaan">Detail Pekerjaan</label>
                                    <textarea class="form-control" name="detail_pekerjaan_selesai" id="detail_pekerjaan_selesai" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="waktu_mulai">Waktu Mulai Pengrjaan</label>
                                    <input type="text" readonly id="waktu_mulai" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gambar_akhir">Foto Selesai Pengerjaan</label>
                                    <input type="file" name="gambar_akhir" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">kembali</button>
                        <button type="submit" class="btn btn-primary btn-md">Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let anggotaIndex = 0;

        $("#form-kerjakan").ajaxForm({
            beforeSend: function() {
                formLoading("#form-kerjakan", ".modal-body", true, true);
            },
            success: function(res) {
                dt.ajax.reload(null, false);
                notif("success", "fas fa-check", "Notifikasi Progress", res.message, "done");
                $("#modalKerjakan").modal("hide");
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
                formLoading("#form-kerjakan", ".modal-body", false);
            }
        });

        $("#form-selesaikan").ajaxForm({
            beforeSend: function() {
                formLoading("#form-selesaikan", ".modal-body", true, true);
            },
            success: function(res) {
                dt.ajax.reload(null, false);
                notif("success", "fas fa-check", "Notifikasi Progress", res.message, "done");
                $("#modalSelesaikan").modal("hide");
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
                formLoading("#form-selesaikan", ".modal-body", false);
            }
        });

        var dt;
        $(document).ready(function() {
            dt = $("#table-data").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.internshipMember.jobdesc.scopeData') }}",
                    type: "post"
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: "false",
                        orderable: "false"
                    },
                    {
                        data: "pekerjaan",
                        name: "pekerjaan"
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
                    {
                        data: "action",
                        name: "action",
                        searchable: "false",
                        orderable: "false"
                    }
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

            $("body").on("click", ".btn-kerjakan", function() {
                formLoading("#form-kerjakan", ".modal-body", true);
                let key = $(this).data("key");
                $.ajax({
                    url: "{{ route('admin.internshipMember.jobdesc.detail') }}",
                    type: "POST",
                    data: {
                        key: key
                    },
                    success: function(res) {
                        console.log(res.data);
                        $('#detail_pekerjaan').val(res.data.pekerjaan)
                        $('#key-pengerjaan').val(key)
                        formLoading("#form-kerjakan", ".modal-body", false);
                    },
                    error: function(err, status, message) {
                        response = err.responseJSON;
                        message = (typeof response != "undefined") ? response.message : message;
                        notif("danger", "fas fa-exclamation", "Notifikasi Error", message,
                            "error");
                    },
                    complete: function() {
                        formLoading("#form-kerjakan", ".modal-body", false);
                    }
                });
                $("#modalKerjakan").modal("show");
            });

            $("body").on("click", ".btn-selesaikan", function() {
                formLoading("#form-selesaikan", ".modal-body", true);
                let key = $(this).data("key");
                $.ajax({
                    url: "{{ route('admin.internshipMember.jobdesc.detail') }}",
                    type: "POST",
                    data: {
                        key: key
                    },
                    success: function(res) {
                        console.log(res.data);
                        $('#detail_pekerjaan_selesai').val(res.data.pekerjaan)
                        $('#waktu_mulai').val(res.data.waktu_mulai)
                        $('#key-selesaikan').val(key)
                        formLoading("#form-selesaikan", ".modal-body", false);
                    },
                    error: function(err, status, message) {
                        response = err.responseJSON;
                        message = (typeof response != "undefined") ? response.message : message;
                        notif("danger", "fas fa-exclamation", "Notifikasi Error", message,
                            "error");
                    },
                    complete: function() {
                        formLoading("#form-selesaikan", ".modal-body", false);
                    }
                });
                $("#modalSelesaikan").modal("show");
            });

            $("body").on("click", ".btn-cancel", function() {
                let key = $(this).data("key");
                swal({
                    title: "Apakah anda yakin?",
                    text: "Batalkan penugasan?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            visible: true,
                            text: 'Batal',
                            className: 'btn btn-danger'
                        },
                        confirm: {
                            text: 'Lanjutkan',
                            className: 'btn btn-primary'
                        }
                    }
                }).then((willDelete) => {
                    if (willDelete) {
                        notifLoading(
                            "Jangan tinggalkan halaman ini sampai proses selesai !");
                        $.ajax({
                            url: "{{ route('admin.internshipMember.jobdesc.cancel') }}",
                            type: "POST",
                            data: {
                                key: key
                            },
                            success: function(res) {
                                notif("success", "fas fa-check", "Notifikasi Progress",
                                    res.message, "done");
                                dt.ajax.reload(null, false);
                            },
                            error: function(err, status, message) {
                                response = err.responseJSON;
                                message = (typeof response != "undefined") ? response
                                    .message : message;
                                notif("danger", "fas fa-exclamation",
                                    "Notifikasi Error", message, "error");
                            },
                            complete: function() {
                                setTimeout(() => {
                                    loadNotif.close();
                                }, 1000);
                            }
                        });
                    }
                });
            });

            $("#modalData").on("hidden.bs.modal", function() {
                $("#password-form").prop("required", true);
                $("#pwInfo").addClass("hidden");
                if ($("#key-form").val()) $("#form-data .form-control").val("");
            });
        });
    </script>
@endsection
