<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi - {{ $periodeText }}</title>
    <style>
        /* Tambahkan CSS simpel agar tabel terlihat rapi saat diprint */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>LAPORAN TRANSAKSI PERPUSTAKAAN DIGITAL</h2>
        <p>Periode: {{ ucfirst($periodeText) }} (Dicetak pada: {{ date('d/m/Y') }})</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $laporan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $laporan->peminjaman->anggota->nama ?? '-' }}</td>
                <td>{{ $laporan->peminjaman->buku->judul ?? '-' }}</td>
                <td>{{ $laporan->peminjaman->tanggal_peminjaman }}</td>
                <td>{{ ucfirst($laporan->status_keterlambatan) }}</td>
                <td>Rp {{ number_format($laporan->total_denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>