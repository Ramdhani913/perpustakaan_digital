<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Gaia Library - #{{ $denda->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; font-size: 13px; color: #000; }
        .text-center { text-align: center; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .flex { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .bold { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3 style="margin: 0;">GAIA LIBRARY</h3>
        <p style="margin: 2px 0;">Struk Pelunasan Denda</p>
        <p style="font-size: 11px;">{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="divider"></div>
    <div class="flex"><span>No Trans:</span><span>#{{ $denda->pengembalian_id }}</span></div>
    <div class="flex"><span>Member:</span><span>{{ $denda->pengembalian->peminjaman->anggota->nama }}</span></div>
    <div class="divider"></div>

    <div class="bold" style="margin-bottom: 5px;">DETAIL DENDA:</div>
    
    {{-- Denda Waktu --}}
    @if($denda->jumlah_hari > 0)
    <div class="flex">
        <span>Telat ({{ $denda->jumlah_hari }} hari)</span>
        <span>Rp {{ number_format($denda->jumlah_hari * 500, 0, ',', '.') }}</span>
    </div>
    @endif

    {{-- Denda Fisik (Selisih total - denda waktu) --}}
    @php $denda_fisik = $denda->total_denda - ($denda->jumlah_hari * 500); @endphp
    @if($denda_fisik > 0)
    <div class="flex">
        <span>Fisik ({{ ucfirst($denda->pengembalian->jenis_pelanggaran) }})</span>
        <span>Rp {{ number_format($denda_fisik, 0, ',', '.') }}</span>
    </div>
    @endif

    <div class="divider"></div>
    <div class="flex bold"><span>TOTAL TAGIHAN</span><span>Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</span></div>
    <div class="flex"><span>DIBAYAR</span><span>Rp {{ number_format($denda->nominal_bayar, 0, ',', '.') }}</span></div>
    <div class="flex"><span>KEMBALIAN</span><span>Rp {{ number_format($denda->nominal_bayar - $denda->total_denda, 0, ',', '.') }}</span></div>

    <div class="divider"></div>
    <div class="text-center" style="font-size: 11px;">
        <p>Buku adalah jendela dunia.<br>Terima kasih sudah menjaga buku kami.</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.close()">Tutup</button>
    </div>
</body>
</html>