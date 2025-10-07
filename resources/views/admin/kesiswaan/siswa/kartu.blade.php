<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu - {{ $siswa->nama }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .id-card {
            width: 320px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .id-card-header {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .student-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin-bottom: 15px;
        }
        .qr-code {
            margin-top: 15px;
        }
        @media print {
            body {
                background-color: white;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="id-card">
        <div class="id-card-header">
            KARTU PELAJAR
        </div>
        
        <img src="{{ $siswa->foto ?? 'https://via.placeholder.com/100' }}" alt="Foto Siswa" class="student-photo">
        
        <h5 class="card-title">{{ $siswa->nama }}</h5>
        <p class="card-text text-muted">{{ $siswa->nisn }}</p>

        <div class="qr-code">
            {{-- Ini adalah kode untuk menampilkan QR Code dari token siswa --}}
            {!! QrCode::size(150)->generate($siswa->qr_token) !!}
        </div>
    </div>

    <button onclick="window.print()" class="btn btn-primary mt-4 no-print">Cetak Kartu</button>

</body>
</html>
