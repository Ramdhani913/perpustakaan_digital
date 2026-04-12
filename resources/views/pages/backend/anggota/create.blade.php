@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Anggota Baru</h4>
                <p class="card-description">
                    Masukkan informasi lengkap data anggota perpustakaan di bawah ini.
                </p>
                
                <form action="{{ route('anggota.store') }}" method="post" enctype="multipart/form-data" class="forms-sample">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email@contoh.com" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password Akun</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 Karakter">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                    <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Foto Profil (Opsional)</label>
                        <input type="file" name="image" class="file-upload-default" id="imageInput">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Foto (Format: JPG, PNG, JPEG)">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Pilih</button>
                            </span>
                        </div>
                        <small class="text-muted">Maksimal ukuran file: 2MB</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Simpan Anggota</button>
                        <a href="{{ route('anggota.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>

                @if ($errors->any())
                <div class="mt-3">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger py-2" role="alert" style="font-size: 0.85rem;">
                            <i class="typcn typcn-info-large mr-1"></i> {{ $error }}
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