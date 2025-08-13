<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran - {{ $proyek->nama_proyek }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { 
            margin-bottom: 20px; 
            padding-bottom: 10px;
            text-align: left;
            border-bottom: 2px solid #333; 
            overflow: auto; 
        }
        .header img { 
            float: left; 
            margin-right: 15px;
            height: 50px; 
            width: auto;
        }
        .header .header-text {
            overflow: hidden; 
        }
        .header .title { font-size: 18px; font-weight: bold; }
        .header .subtitle { font-size: 14px; }
        .header .address { font-size: 10px; }
        .content { margin-top: 25px; }
        .content-title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 5px; }
        .period { text-align: center; font-size: 14px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        .footer { position: fixed; bottom: -20px; width: 100%; text-align: right; font-size: 10px; }
        .footer .page-number:before { content: "Halaman " counter(page); }
    </style>
</head>
<body>

    <div class="header">
        {{-- Pastikan logo ada di public/images/logo-pln.png --}}
        <img src="{{ public_path('images/logo-pln.png') }}" alt="Logo PLN">
        <div class="header-text">
            <div class="title">PT PLN (PERSERO)</div>
            <div class="subtitle">UNIT INDUK PEMBANGUNAN SULAWESI</div>
            <div class="subtitle">UNIT PELAKSANA PROYEK SULAWESI UTARA</div>
            <div class="address">Jl. Bethesda No. 32, Ranotana, Kec. Sario, Kota Manado, Sulawesi Utara</div>
        </div>
    </div>

    <div class="content">
        <div class="content-title">LAPORAN PEMBAYARAN</div>
        {{-- PERUBAHAN: Menambahkan jenis proyek --}}
        <div class="period">
            Proyek: {{ $proyek->nama_proyek }} <br>
            <span style="font-size: 12px;">({{ ucwords(str_replace('-', ' ', $proyek->kategori)) }})</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No Tip</th>
                    <th>Nama Pemilik</th>
                    <th>Desa</th>
                    <th>Nilai</th>
                    <th>Status Bayar</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaranItems as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_tip }}</td>
                        <td>{{ $item->nama_pemilik }}</td>
                        <td>{{ $item->desa }}</td>
                        <td>Rp. {{ number_format($item->nilai, 0, ',', '.') }}</td>
                        <td>{{ $item->status_pembayaran ?? 'Belum Diproses' }}</td>
                        <td>{{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d/m/Y') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->timezone('Asia/Makassar')->translatedFormat('d F Y, H:i') }}
        <div class="page-number"></div>
    </div>

</body>
</html>
