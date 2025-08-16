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
                        <h4 class="card-title">Kehadirans</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm btn-filter"> <span class="fa fa-filter"></span> Filter
                                    Absensi</button>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="table-data" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20px">
                                            <center>No</center>
                                        </th>
                                        <th>Nama</th>
                                        <th width="80px">Divisi</th>
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
                <form id="form-data" method="post" action="{{ route('admin.permintaan.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="key" class="form-control" id="key-form">

                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <h3 class="modal-title" id="modalDataLabel">Detail Peserta Internship</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_pemohon">Nama</label>
                                    <input readonly type="text" name="nama_pemohon" class="form-control"
                                        id="nama_pemohon" value="" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="asal_sekolah_pemohon">Asal Sekolah</label>
                                    <input readonly type="text" name="asal_sekolah_pemohon" class="form-control"
                                        id="asal_sekolah_pemohon" value="" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input readonly type="text" name="nim" class="form-control" id="nim"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <input readonly type="text" name="jurusan" class="form-control" id="jurusan"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="no_hp">NO HP</label>
                                    <input readonly type="text" name="no_hp" class="form-control" id="no_hp"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input readonly type="text" name="email" class="form-control" id="email"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <input readonly type="text" name="divisi" class="form-control" id="divisi"
                                        value="" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input readonly type="text" name="lokasi" class="form-control" id="lokasi"
                                        value="" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true"
        data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document" style="width: 80%">
            <div class="modal-content">
                <form id="filterForm">
                    <div class="form-group">
                        <label for="range-pembelian">Periode</label>
                        <div class="input-group">
                            <input type="date" id="filter-periode_awal" name="filter-periode_awal"
                                class="form-control" max="{{ date('Y-m-d') }}">
                            <span class="separator">&nbsp;s/d&nbsp;</span>
                            <input type="date" id="filter-periode_akhir" name="filter-periode_akhir"
                                class="form-control" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filter-lokasi">Divisi</label>
                        <select class="form-control" id="filter-divisi" name="filter-divisi">
                            <option class="hidden" value=""></option>
                            @foreach ($divisi as $key => $val)
                                <option value="{{ $val->id }}">{{ $val->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md mr-auto" id="reset-filter">Reset Filter</button>
                    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-md" id="submitFilter">Filter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 45%; height:100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-1" id="modalDetailLabel">Absensi : <span id="namaAbsen">Yossandi Imran
                            P</span></h3>
                </div>
                <div class="modal-body" style="height: 100%;">
                    <div class="container-fluid">
                        <div id='calendar'></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light-border.css" />
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        const divisiList = @json($divisi);
        var dt, filterData;

        $(document).ready(function() {
            $("#reset-filter").on("click", function() {
                $("#filterForm .form-control").val("").trigger("change");
            });
            dt = $("#table-data").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.absensi.scopeData') }}",
                    type: "post",
                    data: function(q) {
                        q.filterData = filterData;
                    }
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
                        data: "divisi",
                        name: "divisi"
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

            $("body").on("click", ".btn-filter", function() {
                $("#modalFilter").modal("show");
            })

            $("#submitFilter").on("click", function() {
                var form = $('#filterForm').serialize();
                filterData = form;
                dt.ajax.reload();
                $('#modalFilter').modal('hide');
            });

            $("body").on("click", ".btn-view", function() {
                $('#tabel-anggota tbody').html('');
                $("#modalDataLabel").text("Detail Peserta Internship");
                formLoading("#form-data", "#modal-body", true);
                let key = $(this).data("key");
                $.ajax({
                    url: "{{ route('admin.absensi.detail') }}",
                    type: "POST",
                    data: {
                        key: key,
                        tgl_awal: $('#filter-periode_awal').val(),
                        tgl_akhir: $('#filter-periode_akhir').val()
                    },
                    success: function(res) {
                        console.log(res.data.kehadiran);
                        $("#namaAbsen").text(res.data.nama_pemohon);

                        var events = res.data.kehadiran.map(function(item) {
                            let isTerlambat = false;
                            if (item.jam_masuk) {
                                var jmm = item.jam_masuk.split(' ')[1];
                                console.log("++++++++++++++++++awokawoka+++++++++++++++++++++++++++++++");
                                console.log(jmm);
                                const jam = parseInt(jmm.split(':')[0], 10);
                                const menit = parseInt(jmm.split(':')[1],
                                    10);
                                if (jam > 8 || (jam === 8 && menit > 0)) {
                                    isTerlambat = true;
                                }
                            }

                            return {
                                title: isTerlambat ? 'Terlambat' : 'Hadir',
                                start:  `${item.created_at.split('T')[0]}T08:00:00`,
                                color: isTerlambat ? 'orange' : '',
                                extendedProps: {
                                    foto_masuk: item.foto_masuk,
                                    foto_keluar: item.foto_keluar,
                                    detail: `Absen Masuk: ${item.jam_masuk ?? '-'}\nAbsen Keluar: ${item.jam_keluar ?? '-'}`,
                                    keterangan: isTerlambat ? 'Terlambat' : 'Hadir',
                                },
                            };
                        });

                        var calendarEl = document.getElementById('calendar');
                        var storageBaseUrl = "{{ asset('storage') }}";

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            events: events,
                            eventDidMount: function(info) {
                                const masuk = info.event.extendedProps.foto_masuk ?
                                    `<img src="${storageBaseUrl}/${info.event.extendedProps.foto_masuk}" style="max-width:200px; display:block;">` :
                                    '-';
                                const keluar = info.event.extendedProps
                                    .foto_keluar ?
                                    `<img src="${storageBaseUrl}/${info.event.extendedProps.foto_keluar}" style="max-width:200px; display:block;">` :
                                    '-';

                                const detail = `
                                    <b>${info.event.extendedProps.keterangan}</b><br>
                                    <b>${info.event.extendedProps.detail.replace(/\n/g, '<br>')}</b><br>
                                    <b>Foto Masuk:</b><br>${masuk}
                                    <b>Foto Keluar:</b><br>${keluar}
                                `;

                                tippy(info.el, {
                                    content: detail,
                                    allowHTML: true,
                                    placement: 'right',
                                    theme: 'light-border',
                                });
                            },
                        });

                        $('#modalDetail').modal('show');
                        calendar.render();
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
            });

            $("#modalData").on("hidden.bs.modal", function() {
                $("#password-form").prop("required", true);
                $("#pwInfo").addClass("hidden");
                if ($("#key-form").val()) $("#form-data .form-control").val("");
            });
        });
    </script>
@endsection
