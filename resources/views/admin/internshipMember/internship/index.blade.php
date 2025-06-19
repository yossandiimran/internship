@extends('admin.layouts.app')

@section('css')
<style>
    .modal-lg {
        max-width: 100%;
    }
    #btn-add, #btn-add-multiple {
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
                    <h4 class="card-title">Pengajuan Internship</h4>
                </div>
                <div class="card-body">
                    <button type="button" id="btn-add" class="btn btn-primary btn-md">
                        Buat Pengajuan
                    </button>
                    <div class="table-responsive">
                        <table id="table-data" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="40px">No</th>
                                    <th>Nomor Surat Pengantar</th>
                                    <th>Status</th>
                                    <th width="80px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document" style="width: 80%">
    <div class="modal-content">
      <form id="form-data" method="post" action="{{ route('admin.internshipMember.pengajuan.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="key" class="form-control" id="key-form">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDataLabel">Pengajuan Internship</h5>
        </div>
        <div class="modal-body" id="modal-body">
            <div class="row">
                <div class="col-md-6">
                    {{-- Nama Pemohon --}}
                    <div class="form-group">
                      <label for="nama_pemohon">Nama Pemohon</label>
                      <input readonly type="text" name="nama_pemohon" class="form-control" id="nama_pemohon" value="{{$user->name}}" required/>
                    </div>
                </div>
                <div class="col-md-6">
                    {{-- Asal Sekolah --}}
                    <div class="form-group">
                      <label for="asal_sekolah_pemohon">Asal Sekolah Pemohon</label>
                      <input readonly type="text" name="asal_sekolah_pemohon" class="form-control" id="asal_sekolah_pemohon" value="{{$user->asal_sekolah}}" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {{-- Nama Pemohon --}}
                    <div class="form-group">
                      <label for="jurusan">Jurusan</label>
                      <input readonly type="text" name="jurusan" class="form-control" id="jurusan" value="{{$user->jurusan}}" required/>
                    </div>
                </div>
                <div class="col-md-6">
                    {{-- NIM --}}
                    <div class="form-group">
                        <label for="jurusan">NIM</label>
                        <input readonly type="text" name="nim" class="form-control" id="nim" value="{{$user->nim}}" required/>
                    </div>
                </div>
            </div>
          {{-- Nomor Surat Pengantar --}}
          <div class="form-group">
            <label for="nomor_surat_pengantar">Nomor Surat Pengantar</label>
            <input type="text" name="nomor_surat_pengantar" class="form-control" id="nomor_surat_pengantar" placeholder="Contoh: 420/123/SMKN1" required/>
          </div>

          {{-- Upload File Surat Pengantar --}}
          <div class="form-group">
            <label for="file_surat_pengantar">Upload Surat Pengantar (PDF)</label>
            <input type="file" name="file_surat_pengantar" class="form-control" id="file_surat_pengantar" accept=".pdf" required/>
          </div>

          <hr>

          {{-- Tombol Tambah Anggota --}}
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h4>Data Pemohon Lainya</h4>
            <button type="button" class="btn btn-success btn-sm" id="btnTambahAnggota">
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
                  <th>Jurusan</th>
                  <th>Nomor HP</th>
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
    
    $('#btnTambahAnggota').on('click', function () {
        anggotaIndex++;
        $('#tabel-anggota tbody').append(`
           <tr>
                <td><input type="text" name="anggota[${anggotaIndex}][nama]" class="form-control border-0" required></td>
                <td><input type="text" name="anggota[${anggotaIndex}][email]" class="form-control border-0" required></td>
                <td><input type="text" name="anggota[${anggotaIndex}][no_hp]" class="form-control border-0" required></td>
                <td><input type="text" name="anggota[${anggotaIndex}][jurusan]" class="form-control border-0" required></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-hapus-anggota">Hapus</button></td>
            </tr>
        `);
    });
    // Hapus baris anggota
    $(document).on('click', '.btn-hapus-anggota', function () {
        $(this).closest('tr').remove();
    });

    var dt;
    $(document).ready(function() {

        dt = $("#table-data").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.internshipMember.pengajuan.scopeData') }}",
                type: "post"
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex", searchable: "false", orderable: "false" },
                { data: "nomor_surat_pengantar", name: "nomor_surat_pengantar" },
                { data: "status_surat", name: "status_surat" },
                { data: "action", name: "action", searchable: "false", orderable: "false" }
            ],
            order: [[ 1, "asc" ]],
        });

        $("#btn-add").on("click",function(){
            $("#modalDataLabel").text("Pengajuan Internship");
            $("#modalData").modal("show");
        });

        $("body").on("click",".btn-edit",function(){
            $("#modalDataLabel").text("Ubah Divisi");
            formLoading("#form-data","#modal-body",true);
            let key = $(this).data("key");
            $.ajax({
                url: "{{ route('admin.internshipMember.pengajuan.detail') }}",
                type: "POST",
                data: {key:key},
                success:function(res){
                    $("#key-form").val(key);
                    $.each(res.data,function(k,v){
                        $(`#${k}-form`).val(v).trigger("change");
                    });
                },
                error:function(err, status, message){
                    response = err.responseJSON;
                    message = (typeof response != "undefined") ? response.message : message;
                    notif("danger","fas fa-exclamation","Notifikasi Error",message,"error");
                },
                complete:function(){
                    formLoading("#form-data","#modal-body",false);
                }
            });
            $("#modalData").modal("show");
        });

        $("body").on("click",".btn-delete",function(){
            let key = $(this).data("key");
            swal({
                title: "Apakah anda yakin?",
                text: "Data yang dihapus tidak akan bisa dikembalikan!",
                icon: "warning",
                buttons:{
                    cancel: {
                        visible: true,
                        text : 'Batal',
                        className: 'btn btn-danger'
                    },
                    confirm: {
                        text : 'Yakin',
                        className : 'btn btn-primary'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    notifLoading("Jangan tinggalkan halaman ini sampai proses penghapusan selesai !");
                    $.ajax({
                        url: "{{ route('admin.internshipMember.pengajuan.destroy') }}",
                        type: "POST",
                        data: {key:key},
                        success:function(res){
                            notif("success","fas fa-check","Notifikasi Progress",res.message,"done");
                            dt.ajax.reload(null, false);
                        },
                        error:function(err, status, message){
                            response = err.responseJSON;
                            message = (typeof response != "undefined") ? response.message : message;
                            notif("danger","fas fa-exclamation","Notifikasi Error",message,"error");
                        },
                        complete:function(){
                            setTimeout(() => {
                                loadNotif.close();
                            }, 1000);
                        }
                    });
                }
            });
        });

        $("#modalData").on("hidden.bs.modal",function(){
            $("#password-form").prop("required",true);
            $("#pwInfo").addClass("hidden");
            if($("#key-form").val()) $("#form-data .form-control").val("");
        });

        $("#form-data").ajaxForm({
            beforeSend:function(){
                formLoading("#form-data","#modal-body",true,true);
            },
            success:function(res){
                dt.ajax.reload(null, false);
                notif("success","fas fa-check","Notifikasi Progress",res.message,"done");
                $("#form-data .form-control").val("")
                $("#modalData").modal("hide");
            },
            error:function(err, status, message){
                response = err.responseJSON;
                title = "Notifikasi Error";
                message = (typeof response != "undefined") ? response.message : message;
                if(message == "Error validation"){
                    title = "Error Validasi";
                    $.each(response.data, function(k,v){
                        message = v[0];
                        return false;
                    });
                }
                notif("danger","fas fa-exclamation",title,message,"error");
            },
            complete:function(){
                formLoading("#form-data","#modal-body",false);
            }
        });
    });
</script>
@endsection