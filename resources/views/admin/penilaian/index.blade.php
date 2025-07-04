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
                        <h4 class="card-title">Sertifikat & Penilaian</h4>
                    </div>
                    <div class="card-body">
                        <button type="button" id="btn-add" class="btn btn-primary btn-md">
                            Tambah Sertifikat
                        </button>
                        <div class="table-responsive">
                            <table id="table-data" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20px">
                                            <center>No</center>
                                        </th>
                                        <th>No Sertifikat</th>
                                        <th>Diberikan Kepada</th>
                                        <th>NIM</th>
                                        <th>Asal Sekolah</th>
                                        <th>Jurusan</th>
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

    <div class="modal fade" id="modalData" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document" style="width: 80%">
            <div class="modal-content">
                <form id="form-proses" method="post" action="{{ route('admin.sertifikat.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-form">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Penilaian</h3>
                            </div>
                            </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nomor_surat_penilaian">Nomor Sertifikat</label>
                                    <input readonly type="text" name="nomor_surat_penilaian" class="form-control"
                                        id="nomor_surat_penilaian" value="{{generateNomorSertifikat()}}" required />
                                </div>
                            </div>
                             <div class="col-md-12 viewSerti">
                                <div class="form-group">
                                   <div class="form-group">
                                    <label for="namaSerti">Internship</label>
                                    <input readonly type="text" name="namaSerti" class="form-control"
                                        id="namaSerti" value="" required />
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12 createSerti">
                                <div class="form-group">
                                    <label for="user">Internship</label>
                                    <select name="user" id="user" class="form-control select2">
                                        <option value="">---- Pilih Internship ----</option>
                                        @foreach ($pemohon as $p)
                                        <option value="{{ $p->email }}">{{ $p->nama_pemohon }}</option>
                                        @endForeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>Kriteria Penilaian</h4>
                        <font color="red"><i>*) Point penilaian min 0 - max 4</i></font>    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kedisiplinan">Kedisiplinan</label>
                                    <input type="number" name="kedisiplinan" class="form-control" id="kedisiplinan"
                                        value="" max="4" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggung_jawab">Tanggung Jawab</label>
                                    <input type="number" name="tanggung_jawab" class="form-control" id="tanggung_jawab"
                                        value="" required />
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kerapihan">Kerapihan</label>
                                    <input type="number" name="kerapihan" class="form-control" id="kerapihan"
                                        value="" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="komunikasi">Komunikasi</label>
                                    <input type="number" name="komunikasi" class="form-control" id="komunikasi"
                                        value="" required />
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pemahaman_pekerjaan">Pemahaman</label>
                                    <input type="number" name="pemahaman_pekerjaan" class="form-control" id="pemahaman_pekerjaan"
                                        value="" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="manajemen_waktu">Manajemen Waktu</label>
                                    <input type="number" name="manajemen_waktu" class="form-control" id="manajemen_waktu"
                                        value="" required />
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kerja_sama">Kerja Sama</label>
                                    <input type="number" name="kerja_sama" class="form-control" id="kerja_sama"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kriteria">Predikat</label>
                                    <select name="kriteria" id="kriteria" class="form-control select2">
                                        <option value="Kurang">Kurang</option>
                                        <option value="Cukup">Cukup</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Sangat Baik">Sangat Baik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="routeDownloadSuratBalasan" value="{{ url('/admin/permintaan/downloadSuratBalasan') }}">
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
                    url: "{{ route('admin.sertifikat.scopeData') }}",
                    type: "post"
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: "false",
                        orderable: "false"
                    },
                    {
                        data: "nomor_surat_penilaian",
                        name: "nomor_surat_penilaian"
                    },
                    {
                        data: "user.name",
                        name: "user.name"
                    },
                    {
                        data: "user.nim",
                        name: "user.nim"
                    },
                    {
                        data: "user.asal_sekolah",
                        name: "user.asal_sekolah"
                    },
                    {
                        data: "user.jurusan_detail.jurusan",
                        name: "user.jurusan_detail.jurusan"
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
                $(".viewSerti").hide();
                $(".createSerti").show();
                
                $('#key-form').val("")
                $('#nomor_surat_penilaian').val('{{generateNomorSertifikat()}}')
                $('#user').val("")
                $('#kedisiplinan').val("")
                $('#tanggung_jawab').val("")
                $('#kerapihan').val("")
                $('#komunikasi').val("")
                $('#pemahaman_pekerjaan').val("")
                $('#manajemen_waktu').val("")
                $('#kerja_sama').val("")
                $('#kriteria').val("")
                $("#modalDataLabel").text("Penilaian");
                $("#modalData").modal("show");
            });
                
            $("body").on("click", ".btn-view", function() {
                $("#modalDataLabel").text("Detail Pengajuan");
                formLoading("#form-proses", "#modal-body", true);
                let key = $(this).data("key");
                $.ajax({
                    url: "{{ route('admin.sertifikat.detail') }}",
                    type: "POST",
                    data: {
                        key: key
                    },
                    success: function(res) {
                        console.log(res.data);
                        $(".viewSerti").show();
                        $(".createSerti").hide();
                        $('#namaSerti').val(res.data.user.name)
                        $('#key-form').val(key)
                        $('#nomor_surat_penilaian').val(res.data.nomor_surat_penilaian)
                        $('#user').val(res.data.user)
                        $('#kedisiplinan').val(res.data.kedisiplinan)
                        $('#tanggung_jawab').val(res.data.tanggung_jawab)
                        $('#kerapihan').val(res.data.kerapihan)
                        $('#komunikasi').val(res.data.komunikasi)
                        $('#pemahaman_pekerjaan').val(res.data.pemahaman_pekerjaan)
                        $('#manajemen_waktu').val(res.data.manahemen_waktu)
                        $('#kerja_sama').val(res.data.kerja_sama)
                        $('#kriteria').val(res.data.kriteria)
                        formLoading("#form-prses", "#modal-body", false);
                    },
                    error: function(err, status, message) {
                        response = err.responseJSON;
                        message = (typeof response != "undefined") ? response.message : message;
                        notif("danger", "fas fa-exclamation", "Notifikasi Error", message,
                            "error");
                    },
                    complete: function() {
                        formLoading("#form-proses", "#modal-body", false);
                    }
                });
                $("#modalData").modal("show");
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
                            url: "{{ route('admin.sertifikat.destroy') }}",
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
