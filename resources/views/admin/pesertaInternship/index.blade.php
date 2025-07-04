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
                        <h4 class="card-title">Peserta Internship</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-data" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20px">
                                            <center>No</center>
                                        </th>
                                        <th>Nama</th>
                                        <th>Asak Sekolah</th>
                                        <th>Divisi</th>
                                        <th>Jurusan</th>
                                        <th width="20px">
                                            <center>Status</center>
                                        </th>
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
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <div class="modal-content">
                <form id="form-data" method="post" action="{{ route('admin.permintaan.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-form">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Pengajuan Internship</h3>
                            </div>
                            <div class="col-md-1 viewSuratPengantarDetail">
                                <button class="btn btn-primary btn-sm btn-status-permohonan">Dikirim</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Nama Pemohon --}}
                                <div class="form-group">
                                    <label for="nama_pemohon">Nama Pemohon</label>
                                    <input readonly type="text" name="nama_pemohon" class="form-control"
                                        id="nama_pemohon" value="" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Asal Sekolah --}}
                                <div class="form-group">
                                    <label for="asal_sekolah_pemohon">Asal Sekolah Pemohon</label>
                                    <input readonly type="text" name="asal_sekolah_pemohon" class="form-control"
                                        id="asal_sekolah_pemohon" value="" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Nama Pemohon --}}
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <input readonly type="text" name="jurusan" class="form-control" id="jurusan"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- NIM --}}
                                <div class="form-group">
                                    <label for="jurusan">NIM</label>
                                    <input readonly type="text" name="nim" class="form-control" id="nim"
                                        value="" required />
                                </div>
                            </div>
                        </div>
                        {{-- Nomor Surat Pengantar --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_surat_pengantar">Nomor Surat Pengantar</label>
                                    <input type="text" name="nomor_surat_pengantar" class="form-control"
                                        id="nomor_surat_pengantar" placeholder="Contoh: 420/123/SMKN1" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_surat_balasan">Nomor Surat Balasan</label>
                                    <input type="text" name="nomor_surat_balasan" class="form-control"
                                        id="nomor_surat_balasan" placeholder="Contoh: 420/123/SMKN1" readonly />
                                </div>
                            </div>
                        </div>


                        {{-- Upload File Surat Pengantar --}}
                        <hr>
                        <div class="form-group upSuratPengantar">
                            <label for="file_surat_pengantar">Upload Surat Pengantar (PDF)</label>
                            <input type="file" name="file_surat_pengantar" class="form-control" id="file_surat_pengantar"
                                accept=".pdf" required />
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group viewSuratPengantar"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group viewSuratBalasan"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group viewSuratMou"></div>
                            </div>
                        </div>
                        <hr>

                        {{-- Tombol Tambah Anggota --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4>Data Pemohon Lainya</h4><br>
                            <button type="button" class="btn btn-success btn-sm upSuratPengantar" id="btnTambahAnggota">
                                <i class="bi bi-plus-circle"></i> Tambah Pemohon
                            </button>
                        </div>

                        {{-- Tabel Anggota --}}
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabel-anggota">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor HP</th>
                                        <th>NIM</th>
                                        <th>Jurusan</th>
                                        <th>Divisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Baris dinamis akan ditambahkan di sini --}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-md upSuratPengantar">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Proses --}}
    <div class="modal fade" id="modalProses" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document" style="width: 95%">
            <div class="modal-content">
                <form id="form-proses" method="post" action="{{ route('admin.permintaan.uploadSuratBalasan') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key_proses" class="form-control" id="key-form-proses">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Proses Pengajuan Internship</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nomor_surat_balasan">Nomor Surat Balasan</label>
                                    <input type="text" name="nomor_surat_balasan" class="form-control"
                                        value="{{ generateNomorSuratBalasan() }}" id="nomor_surat_balasan"
                                        placeholder="Contoh: 420/123/SMKN1" readonly />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status_surat">Status Penerimaan</label>
                                    <select class="form-control" name="status_surat" id="status_surat">
                                        <option value="4">Sudah Kami Terima</option>
                                        <option value="3">Belum Bisa Kami Terima</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_surat_balasan">Tanggal Surat Balasan</label>
                                    <input type="date" name="tanggal_surat_balasan" class="form-control"
                                        id="tanggal_surat_balasan" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pembimbing">Pembimbing</label>
                                    <input type="text" name="pembimbing" class="form-control" id="pembimbing"
                                        placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periode_awal">Tanggal Mulai</label>
                                    <input type="date" name="periode_awal" class="form-control" id="periode_awal"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periode_akhir">Tanggal Akhir</label>
                                    <input type="date" name="periode_akhir" class="form-control" id="periode_akhir"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group upSuratPengantar">
                                    <label for="ttd_digital">Upload TTD Digital / QrCode</label>
                                    <input type="file" name="ttd_digital" class="form-control" id="ttd_digital"
                                        accept=".png" required />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <b>Pemohon : </b>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabel-anggota-acc">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor HP</th>
                                        <th>NIM</th>
                                        <th>Jurusan</th>
                                        <th>Divisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Baris dinamis akan ditambahkan di sini --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-md">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="routeDownloadSuratBalasan" value="{{ url('/admin/permintaan/downloadSuratBalasan') }}">
@endsection

@section('js')
    <script>
        const divisiList = @json($divisi);

        $("body").on("click", ".btn-selesai", function() {
            let key = $(this).data("key");
            swal({
                title: "Selesai",
                text: "Selesaikan Internship?",
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
                    notifLoading("Jangan tinggalkan halaman ini sampai proses penghapusan selesai !");
                    $.ajax({
                        url: "{{ route('admin.permintaan.selesai') }}",
                        type: "POST",
                        data: {
                            key: key
                        },
                        success: function(res) {
                            notif("success", "fas fa-check", "Notifikasi Progress", res.message,
                                "done");
                            dt.ajax.reload(null, false);
                        },
                        error: function(err, status, message) {
                            response = err.responseJSON;
                            message = (typeof response != "undefined") ? response.message :
                                message;
                            notif("danger", "fas fa-exclamation", "Notifikasi Error", message,
                                "error");
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

        $("body").on("click", ".btn-tolak", function() {
            let key = $(this).data("key");
            swal({
                title: "Acc",
                text: "Tolak Permintaan Internship?",
                icon: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: 'Batal',
                        className: 'btn btn-danger'
                    },
                    confirm: {
                        text: 'Tolak',
                        className: 'btn btn-primary'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    notifLoading("Jangan tinggalkan halaman ini sampai proses penghapusan selesai !");
                    $.ajax({
                        url: "{{ route('admin.permintaan.tolak') }}",
                        type: "POST",
                        data: {
                            key: key
                        },
                        success: function(res) {
                            notif("success", "fas fa-check", "Notifikasi Progress", res.message,
                                "done");
                            dt.ajax.reload(null, false);
                        },
                        error: function(err, status, message) {
                            response = err.responseJSON;
                            message = (typeof response != "undefined") ? response.message :
                                message;
                            notif("danger", "fas fa-exclamation", "Notifikasi Error", message,
                                "error");
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


        let anggotaIndex = 0;

        $("#form-proses").ajaxForm({
            beforeSend: function() {
                formLoading("#form-proses", "#modal-body", true, true);
            },
            success: function(res) {
                dt.ajax.reload(null, false);
                notif("success", "fas fa-check", "Notifikasi Progress", res.message, "done");
                $("#form-data .form-control").val("")
                $("#modalProses").modal("hide");
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
                formLoading("#form-data", "#modal-body", false);
            }
        });

        $("body").on("click", ".btn-proses", function() {
            let key = $(this).data("key");
            $('#key-form-proses').val(key);
            console.log(key);

            let divisiOption = '';
            divisiList.forEach(j => {
                divisiOption += `<option value="${j.id}">${j.divisi}</option>`;
            });
            $('#tabel-anggota-acc tbody').html('');
            $.ajax({
                url: "{{ route('admin.permintaan.detail') }}",
                type: "POST",
                data: {
                    key: key
                },
                success: function(res) {
                    $.each(res.data.pemohon, function(i, pm) {
                        $('#tabel-anggota-acc tbody').append(`
                            <tr>
                                <td>${pm.nama_pemohon}</td>
                                <td>${pm.email ?? ''}</td>
                                <td>${pm.no_hp ?? ''}</td>
                                <td>${pm.nim ?? ''}</td>
                                <td>${pm.pemohon.jurusan_detail.jurusan ?? ''}</td>
                                <td>
                                    <input type="hidden" name="anggota[${i}][email]" value="${pm.email}" class="form-control border-0" required>
                                    <select name="anggota[${i}][divisi]" class="form-control border-0" required>
                                        ${divisiOption}
                                    </select>
                                </td>
                            </tr>
                        `);
                    });


                },
                error: function(err, status, message) {
                    response = err.responseJSON;
                    message = (typeof response != "undefined") ? response.message : message;
                    notif("danger", "fas fa-exclamation", "Notifikasi Error", message, "error");
                },
                complete: function() {
                    formLoading("#form-data", "#modal-body", false);
                }
            });

            $("#modalProses").modal("show");
        });


        $('#btnTambahAnggota').on('click', function() {
            anggotaIndex++;
            let divisiOption = '';
            divisiList.forEach(j => {
                divisiOption += `<option value="${j.id}">${j.jurusan}</option>`;
            });
            $('#tabel-anggota tbody').append(`
           <tr>
                <td><input type="text" name="anggota[${anggotaIndex}][nama]" class="form-control border-0" required></td>
                <td><input type="text" name="anggota[${anggotaIndex}][email]" class="form-control border-0" required></td>
                <td><input type="text" name="anggota[${anggotaIndex}][no_hp]" class="form-control border-0" required></td>
                <td>
                    <select name="anggota[${anggotaIndex}][jurusan]" class="form-control border-0" required>
                    ${divisiOption}
                    </select>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm btn-hapus-anggota">Hapus</button></td>
            </tr>
        `);
        });
        // Hapus baris anggota
        $(document).on('click', '.btn-hapus-anggota', function() {
            $(this).closest('tr').remove();
        });

        var dt;
        $(document).ready(function() {

            dt = $("#table-data").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.peserta.scopeData') }}",
                    type: "post"
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        searchable: "false",
                        orderable: "false"
                    },
                    {
                        data: "nama_pemohon",
                        name: "nama_pemohon"
                    },
                    {
                        data: "asal_sekolah",
                        name: "asal_sekolah"
                    },
                    {
                        data: "divisi.divisi",
                        name: "divisi.divisi"
                    },
                    {
                        data: "jurusan.jurusan",
                        name: "jurusan.jurusan"
                    },
                    {
                        data: "status_internship",
                        name: "status_internship"
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
                console.log(pengajuanList);
                if (pengajuanList.length == 0) {
                    $(".upSuratPengantar").show();
                    $(".viewSuratPengantarDetail").hide();
                    $(".viewSuratPengantar").hide();
                    $('#nomor_surat_pengantar').val("").prop('readonly', false)

                    $("#modalDataLabel").text("Pengajuan Internship");
                    $("#modalData").modal("show");
                } else {
                    notif("warning", "fas fa-exclamation", "Perhatian !",
                        'Tidak dapat membuat pengajuan lain karena anda sudah memiliki 1 pengajuan yang berjalan',
                        "error");
                }
            });

            $("body").on("click", ".btn-view", function() {
                $('#tabel-anggota tbody').html('');
                $("#modalDataLabel").text("Detail Pengajuan");
                formLoading("#form-data", "#modal-body", true);
                let key = $(this).data("key");
                $.ajax({
                    url: "{{ route('admin.permintaan.detail') }}",
                    type: "POST",
                    data: {
                        key: key
                    },
                    success: function(res) {
                        console.log(res.data);
                        $('#nama_pemohon').val(res.data.pemohon_utama.name).prop('readonly',
                            true)
                        $('#asal_sekolah_pemohon').val(res.data.pemohon_utama.asal_sekolah)
                            .prop('readonly', true)
                        $('#jurusan').val(res.data.pemohon_utama.jurusan_detail.jurusan).prop(
                            'readonly', true)
                        $('#nim').val(res.data.pemohon_utama.nim).prop('readonly', true)
                        $('#nomor_surat_pengantar').val(res.data.nomor_surat_pengantar).prop(
                            'readonly', true)
                        $('#nomor_surat_balasan').val(res.data.nomor_surat_balasan).prop(
                            'readonly', true)

                        const fileUrlPengantar =
                            `{{ asset('storage/') }}/${res.data.file_surat_pengantar}`;
                        const fileUrlBalasan =
                            `{{ asset('storage/') }}/${res.data.file_surat_balasan}`;
                        const fileUrlMou =
                            `{{ asset('storage/') }}/${res.data.file_surat_mou}`;

                        let statusHtml = '';

                        if (res.data.status_surat == 1) {
                            statusHtml =
                                `<button class="btn btn-primary btn-md btn-status-permohonan">Dikirim</button>`;
                        } else if (res.data.status_surat == 2) {
                            statusHtml =
                                `<button class="btn btn-warning btn-md btn-status-permohonan">Diproses</button>`;
                        } else if (res.data.status_surat == 3) {
                            statusHtml =
                                `<button class="btn btn-danger btn-md btn-status-permohonan">Ditolak</button>`;
                        } else if (res.data.status_surat == 4) {
                            statusHtml =
                                `<button class="btn btn-warning btn-md btn-status-permohonan">Ditinjau</button>`;
                        } else if (res.data.status_surat == 5) {
                            statusHtml =
                                `<button class="btn btn-success btn-md btn-status-permohonan">Aktif</button>`;
                        } else {
                            statusHtml =
                                `<button class="btn btn-secondary btn-md btn-status-permohonan">Selesai</button>`;
                        }
                        $('.btn-status-permohonan').replaceWith(statusHtml);

                        // Sembunyiin input file, tampilkan view link
                        $(".upSuratPengantar").hide();
                        $(".viewSuratPengantarDetail").show();

                        $(".viewSuratPengantar").show().html(`
                        <label>Surat Pengantar</label><br>
                        <a href="${fileUrlPengantar}" target="_blank" class="btn btn-lg btn-warning">
                            <i class="fas fa-file"></i>&nbsp;&nbsp;Unduh Surat Pengantar
                        </a>
                    `);

                        // if (res.data.file_surat_balasan != null) {
                        //     $(".viewSuratBalasan").show().html(`
                    //     <label>Surat Balasan</label><br>
                    //     <a href="${fileUrlBalasan}" target="_blank" class="btn btn-lg btn-warning">
                    //         <i class="fas fa-file"></i>&nbsp;&nbsp;Unduh Surat Balasan
                    //     </a>
                    // `);
                        // }

                        let baseDownload = $('#routeDownloadSuratBalasan').val();
                        let finalUrl = `${baseDownload}/${key}`;

                        $(".viewSuratBalasan").show().html(`
                            <label>Surat Balasan</label><br>
                            <a href="${finalUrl}" target="_blank" class="btn btn-lg btn-warning">
                                <i class="fas fa-file"></i>&nbsp;&nbsp;Unduh Surat Balasan
                            </a>
                        `);

                        if (res.data.file_surat_mou != null) {
                            $(".viewSuratMou").show().html(`
                            <label>Surat MOU</label><br>
                            <a href="${fileUrlMou}" target="_blank" class="btn btn-lg btn-warning">
                                <i class="fas fa-file"></i>&nbsp;&nbsp;Lihat Surat MOU
                            </a>
                        `);
                        } else {
                            $(".viewSuratMou").hide().html();
                        }

                        $.each(res.data.pemohon, function(i, pm) {
                            $('#tabel-anggota tbody').append(`
                            <tr>
                                <td>${pm.nama_pemohon}</td>
                                <td>${pm.email ?? ''}</td>
                                <td>${pm.no_hp ?? ''}</td>
                                <td>${pm.nim ?? ''}</td>
                                <td>${pm.pemohon.jurusan_detail.jurusan ?? ''}</td>
                                <td>${pm.divisi != null  ? pm.divisi.divisi : '-'}</td>
                                <td>#</td>
                            </tr>
                        `);
                        });


                    },
                    error: function(err, status, message) {
                        response = err.responseJSON;
                        message = (typeof response != "undefined") ? response.message : message;
                        notif("danger", "fas fa-exclamation", "Notifikasi Error", message,
                            "error");
                    },
                    complete: function() {
                        formLoading("#form-data", "#modal-body", false);
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
                            url: "{{ route('admin.permintaan.destroy') }}",
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
