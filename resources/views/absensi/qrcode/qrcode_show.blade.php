<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Absensi untuk {{ $user->nama }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f5fb;
        }
        .card {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-top: 0;
            margin-bottom: 8px;
            color: #333;
        }
        p {
            margin-top: 0;
            margin-bottom: 20px;
            color: #777;
        }
        .qr-code {
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>{{ $user->nama }}</h2>
        <p>{{ $role }}</p>
        <div class="qr-code">
            {{-- Ini adalah bagian penting yang membuat gambar QR Code --}}
            {{-- Isinya adalah ROLE:ID, contoh: "GTK:1" atau "Siswa:150" --}}
            {!! QrCode::size(250)->generate($role . ':' . $user->id) !!}
        </div>
    </div>
    <script>
        // Script ini akan otomatis membuka dialog print saat halaman selesai dimuat.
        // Sangat berguna jika Admin ingin langsung mencetak kartu.
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>