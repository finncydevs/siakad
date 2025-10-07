<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Massal - {{ $rombel->nama }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --card-width: 60mm;
            --card-height: 95mm;
        }

        body {
            background-color: #e9e9e9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .a4-sheet {
            background: white;
            width: 210mm;
            height: 297mm;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(3, 1fr);
            padding: 3mm 10mm; 
            gap: 3mm 5mm; 
            box-sizing: border-box;
            justify-items: center;
        }
        
        .page-break {
            page-break-after: always;
        }

        .id-card {
            width: var(--card-width);
            height: var(--card-height);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background-color: white;
            border: 1px solid #eee;
        }
        
        .id-card-header {
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: bold;
            color: #333;
            flex-shrink: 0;
        }
        
        .school-logo {
            width: 24px;
            height: 24px;
        }

        .card-photo-area {
            flex-grow: 1;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.85) 20%, rgba(0,0,0,0) 50%, rgba(0,0,0,0.1) 100%);
            z-index: 1;
        }
        
        .card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            /* PERUBAHAN: Padding bawah ditambah untuk memberi ruang QR code yang lebih besar */
            padding: 0 12px 95px 12px; 
            box-sizing: border-box;
            z-index: 2;
            color: white;
        }

        .student-info .nama {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
            text-shadow: 1px 1px 4px rgba(0,0,0,1);
        }
        
        .student-info .nisn {
            font-size: 11px;
            background-color: rgba(255, 255, 255, 0.25);
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .qr-code {
            position: absolute;
            bottom: 15px;
            right: 15px;
            z-index: 2;
        }
        
        .qr-code svg {
            /* PERUBAHAN: Ukuran QR code diperbesar lagi */
            width: 22mm;
            height: 22mm;
            display: block;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        @media print {
            body { background-color: white; }
            .a4-sheet { margin: 0; box-shadow: none; }
            .id-card { border: 1px dashed #999; }
            .print-button { display: none; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn btn-primary print-button">
        <i class='bx bx-printer'></i> Cetak Halaman
    </button>
    
    @php $kartuPerPage = 9; @endphp
    @forelse ($siswas->chunk($kartuPerPage) as $chunk)
        <div class="a4-sheet {{ !$loop->last ? 'page-break' : '' }}">
            @foreach ($chunk as $siswa)
            <div class="id-card">
                <div class="id-card-header">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="school-logo">
                    <span>KARTU PESERTA DIDIK</span>
                </div>
                
                <div class="card-photo-area" style="background-image: url('{{ $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://via.placeholder.com/400x600' }}');">
                    <div class="card-overlay"></div>

                    <div class="card-content">
                        <div class="student-info">
                            <div class="nama">{{ $siswa->nama }}</div>
                            <div class="nisn">{{ $siswa->nisn }}</div>
                        </div>
                    </div>

                    <div class="qr-code">
                        @php
                            $svg = QrCode::size(150)->generate($siswa->qr_token);
                            $svg = preg_replace('/<rect.*?fill="#ffffff".*?\/>/', '', $svg);
                            $svg = str_replace('fill="#000000"', 'fill="#ffffff"', $svg);
                        @endphp
                        
                        {!! $svg !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @empty
        <div style="text-align: center; padding: 50px; font-size: 1.2rem;">
            <i class='bx bx-user-x' style="font-size: 5rem; color: #ccc;"></i>
            <h3 class="mt-3">Tidak Ada Siswa di Kelas Ini</h3>
            <p>Tidak ada kartu yang dapat dicetak.</p>
        </div>
    @endforelse

</body>
</html>