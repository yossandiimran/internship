@extends('admin.layouts.app')

@section('css')
    <style>
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
                        <h4 class="card-title">Profile {{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form id="form-update-profile">
                                @csrf
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                                 <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                                 <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control">{{ $user->alamat }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control" value="{{ $user->kota }}">
                                </div>
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control"
                                        value="{{ $user->provinsi }}">
                                </div>
                                 <div class="form-group">
                                    <label>NIM</label>
                                    <input type="text" name="nim" class="form-control"
                                        value="{{ $user->nim }}">
                                </div>
                                <div class="form-group">
                                    <label>Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah" class="form-control"
                                        value="{{ $user->asal_sekolah }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var dt;
        $(document).ready(function() {});

        $('#form-update-profile').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route('admin.internshipMember.profile.updateProfile') }}',
                method: 'POST',
                data: formData,
                success: function(res) {
                     notif("success","fas fa-check","Notifikasi Progress",res.message,"done");
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function(key, value) {
                        errorMsg += value + '<br>';
                    });
                   notif("danger","fas fa-exclamation","Notifikasi Error",message,"error");
                }
            });
        });
    </script>
@endsection
