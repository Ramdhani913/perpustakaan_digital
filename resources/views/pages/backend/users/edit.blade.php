@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit User: {{ $user->name }}</h4>
                <p class="card-description">
                    Perbarui informasi detail akun pengguna di bawah ini.
                </p>
                
                <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data" class="forms-sample">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="email@contoh.com" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                <small class="text-muted">Isi hanya jika ingin mengganti password.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">Nomor HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxx" value="{{ old('no_hp', $user->no_hp) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $user->tgl_lahir) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role">Hak Akses (Role)</label>
                                <select class="form-control" name="role" id="role">
                                    <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="kepala" {{ old('role', $user->role) == 'kepala' ? 'selected' : '' }}>Kepala Perpustakaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                    <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status Akun</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="image" class="file-upload-default" id="imageInput">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Foto Baru jika ingin mengganti">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('imageInput').click();">Pilih</button>
                            </span>
                        </div>
                        @if($user->image)
                            <div class="mt-2">
                                <small>Foto saat ini:</small><br>
                                <img src="{{ asset('storage/' . $user->image) }}" alt="profil" width="100" class="rounded mt-1 shadow-sm">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
                </form>

                @if ($errors->any())
                <div class="mt-3">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger py-2" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('imageInput');
        const fileInfo = document.querySelector('.file-upload-info');
        const browseBtn = document.querySelector('.file-upload-browse');

        if (browseBtn) {
            browseBtn.addEventListener('click', function() {
                fileInput.click();
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileInfo.value = this.files[0].name;
                }
            });
        }
    });
</script>
@endsection