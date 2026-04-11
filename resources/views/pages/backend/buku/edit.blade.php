@extends('layouts.backend.app')

@section('content')
    <div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Data Buku</h4>
                <p class="card-description">
                    Ubah informasi buku <strong>{{ $buku->judul }}</strong>
                </p>
                
                <form action="{{ route('buku.update', $buku->id) }}" method="post" enctype="multipart/form-data" class="forms-sample">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun_terbit">Tahun Terbit</label>
                                <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pengarang">Pengarang</label>
                                <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select class="form-control" name="kategori" id="kategori">
                                    <option value="novel" @selected(old('kategori', $buku->kategori) == 'novel')>Novel</option>
                                    <option value="komik" @selected(old('kategori', $buku->kategori) == 'komik')>Komik</option>
                                    <option value="majalah" @selected(old('kategori', $buku->kategori) == 'majalah')>Majalah</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok">Stok Buku</label>
                                <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kondisi">Kondisi</label>
                                <select class="form-control" name="kondisi" id="kondisi">
                                    <option value="layak" @selected(old('kondisi', $buku->kondisi) == 'layak')>Layak</option>
                                    <option value="rusak" @selected(old('kondisi', $buku->kondisi) == 'rusak')>Rusak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Gambar Buku (Saat Ini)</label><br>
                        @if($buku->gambar)
                            <img src="{{ asset('storage/' . $buku->gambar) }}" alt="image" class="img-thumbnail mb-3" style="max-width: 150px;">
                        @endif
                        
                        <input type="file" name="gambar" class="file-upload-default" id="gambarInput">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Kosongkan jika tidak ingin mengubah gambar">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('gambarInput').click();">Ganti Gambar</button>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Update Data</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </form>

                @if ($errors->any())
                <div class="mt-3">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger py-1" role="alert">
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
    // Script agar nama file muncul saat dipilih
    document.getElementById('gambarInput').onchange = function() {
        document.querySelector('.file-upload-info').value = this.files[0].name;
    };
</script>
@endsection