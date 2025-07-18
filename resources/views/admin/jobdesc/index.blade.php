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
                        <button type="button" id="btn-add" class="btn btn-primary btn-md">
                            Tambah Pekerjaan
                        </button>
                        <div class="table-responsive">
                            <table id="table-data" class="table table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20px">
                                            <center>No</center>
                                        </th>
                                        <th>Deskripsi Pekerjaan</th>
                                        <th>Ditugaskan kepada</th>
                                        <th width="20px">Divisi</th>
                                        <th>
                                            <center>Mulai Dikerjakan</center>
                                        </th>
                                        <th>
                                            <center>Selesai Dikerjakan</center>
                                        </th>
                                        <th>Status</th>
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
                <form id="form-proses" method="post" action="{{ route('admin.jobdesc.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-form">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title">Jobdesc</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="assign_to">Ditugaskan Kepada</label>
                                    <select name="assign_to" id="assign_to" class="form-control select2">
                                        <option value="">---- Pilih Internship ----</option>
                                        @foreach ($pemohon as $p)
                                            <option value="{{ $p->email }}">{{ $p->nama_pemohon }} -
                                                {{ $p->divisi->divisi }}</option>
                                        @endForeach
                                    </select>
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
@endsection

@section('js')
    <script>
        let anggotaIndex = 0;

        $("#form-proses").ajaxForm({
            beforeSend: function() {
                formLoading("#form-proses", "#modal-body", true, true);
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
                formLoading("#form-proses", "#modal-body", false);
            }
        });

        var dt;
        $(document).ready(function() {

            $('#user').select2({
                dropdownParent: $('#modalData'),
                width: '100%',
                placeholder: 'Pilih Internship',
                allowClear: true
            });

            dt = $("#table-data").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.jobdesc.scopeData') }}",
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
                        data: "assign_to.nama_pemohon",
                        name: "assign_to.nama_pemohon"
                    },
                    {
                        data: "assign_to.divisi.divisi",
                        name: "assign_to.divisi.divisi"
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
                order: [
                    [0, "asc"]
                ],
            });

            $("#btn-add").on("click", function() {
                $('#key-form').val("")
                $('#assign_to').val("")
                $('#pekerjaan').val("")
                $("#modalData").modal("show");
            });

            $('body').on('click', 'img[data-toggle="modal"]', function() {
                const imgUrl = $(this).data('img');
                $('#modalImage').attr('src', imgUrl);
            });

            $("body").on("click", ".btn-delete", function() {
                let key = $(this).data("key");
                swal({
                    title: "Apakah anda yakin?",
                    text: "Data yang dihapus tidak akan bisa dikembalikan!",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            visible: true,
                            text: 'Batal',
                            className: 'btn btn-danger'
                        },
                        confirm: {
                            text: 'Yakin',
                            className: 'btn btn-primary'
                        }
                    }
                }).then((willDelete) => {
                    if (willDelete) {
                        notifLoading(
                            "Jangan tinggalkan halaman ini sampai proses penghapusan selesai !");
                        $.ajax({
                            url: "{{ route('admin.jobdesc.destroy') }}",
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
                            url: "{{ route('admin.jobdesc.cancel') }}",
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

            $("body").on("click", ".btn-selesai", function() {
                let key = $(this).data("key");
                swal({
                    title: "Apakah anda yakin?",
                    text: "Verifikasi Pekerjaan?",
                    icon: "success",
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
                            url: "{{ route('admin.jobdesc.verifikasi') }}",
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
