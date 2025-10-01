<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Massal - {{ $rombel->nama }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .page-break {
            page-break-after: always;
        }
        .id-card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .id-card {
            width: 100%; /* Lebar kartu menyesuaikan grid */
            max-width: 340px; /* Lebar maksimal */
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin: 0 auto; /* Pusatkan kartu di dalam grid cell */
        }
        .id-card-header {
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
        }
        .student-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin-bottom: 10px;
        }
        .qr-code {
            margin-top: 10px;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        /* Aturan untuk mode cetak */
        @media print {
            body {
                background-color: white;
            }
            .print-button {
                display: none;
            }
            .id-card-container {
                padding: 0;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn btn-primary print-button">
        <i class="bx bx-printer"></i> Cetak Halaman Ini
    </button>

    <div class="id-card-container">
        @forelse ($siswas as $siswa)
        <div class="id-card">
            <div class="id-card-header">
                KARTU PELAJAR
            </div>
            
            <img src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://via.placeholder.com/80' }}" alt="Foto Siswa" class="student-photo">
            
            <h6 class="card-title mb-1">{{ $siswa->nama }}</h6>
            <p class="card-text text-muted small">{{ $siswa->nisn }}</p>

            <div class="qr-code">
                {!! QrCode::size(120)->generate($siswa->qr_token) !!}
            </div>
        </div>
        @empty
        <p>Tidak ada siswa di kelas ini.</p>
        @endforelse
    </div>

</body>
</html>
