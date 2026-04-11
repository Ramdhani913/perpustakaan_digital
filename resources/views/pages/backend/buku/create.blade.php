@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Buku Baru</h4>
                <p class="card-description">
                    Masukkan informasi detail buku di bawah ini.
                </p>
                
                <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data" class="forms-sample">
                    @csrf

                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul" value="{{ old('judul') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Nama Penerbit" value="{{ old('penerbit') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun_terbit">Tahun Terbit</label>
                                <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pengarang">Pengarang</label>
                                <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Nama Pengarang" value="{{ old('pengarang') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select class="form-control" name="kategori" id="kategori">
                                    <option value="novel" {{ old('kategori') == 'novel' ? 'selected' : '' }}>Novel</option>
                                    <option value="komik" {{ old('kategori') == 'komik' ? 'selected' : '' }}>Komik</option>
                                    <option value="majalah" {{ old('kategori') == 'majalah' ? 'selected' : '' }}>Majalah</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok">Stok Buku</label>
                                <input type="number" class="form-control" id="stok" name="stok" placeholder="Jumlah Stok" value="{{ old('stok') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kondisi">Kondisi</label>
                                <select class="form-control" name="kondisi" id="kondisi">
                                    <option value="layak" {{ old('kondisi') == 'layak' ? 'selected' : '' }}>Layak</option>
                                    <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <input type="file" name="gambar" class="file-upload-default" id="gambarInput">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('gambarInput').click();">Pilih</button>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
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
        // Cari input file asli
        const fileInput = document.querySelector('.file-upload-default');
        // Cari kolom teks placeholder
        const fileInfo = document.querySelector('.file-upload-info');
        // Cari tombol pilih
        const browseBtn = document.querySelector('.file-upload-browse');

        // Jika tombol diklik, trigger input file asli
        if (browseBtn) {
            browseBtn.addEventListener('click', function() {
                fileInput.click();
            });
        }

        // Jika file dipilih, masukkan namanya ke placeholder
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                // Ambil hanya nama filenya saja (tanpa path C:\fakepath\)
                let fileName = this.files[0].name;
                fileInfo.value = fileName;
            });
        }
    });
</script>
@endsection