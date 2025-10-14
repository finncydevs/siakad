<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenericSyncController extends Controller
{
    /**
     * Menangani semua permintaan sinkronisasi secara dinamis,
     * membuat atau mengubah tabel dan kolom sesuai kebutuhan.
     */
    public function handleSync(Request $request, $entity)
    {
        $dataFromDapodik = $request->all();

        if (empty($dataFromDapodik)) {
            return response()->json(['message' => 'Tidak ada data yang dikirim.'], 200);
        }

        // 1. Tentukan nama tabel dari nama entitas (misal: 'gtk' -> 'gtks')
        $tableName = Str::plural(Str::snake($entity));

        // 2. Ambil semua nama kolom dari data pertama yang dikirim
        $dapodikColumns = array_keys($dataFromDapodik[0]);

        // 3. Cek apakah tabel sudah ada. Jika belum, buat tabelnya.
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) use ($dapodikColumns) {
                $table->id(); // Kolom ID utama

                // Loop untuk membuat semua kolom secara dinamis
                foreach ($dapodikColumns as $column) {
                    $this->defineColumnType($table, $column);
                }
                $table->timestamps();
            });
        } else {
            $existingColumns = Schema::getColumnListing($tableName);
            $newColumns = array_diff($dapodikColumns, $existingColumns);

            if (!empty($newColumns)) {
                Schema::table($tableName, function ($table) use ($newColumns) {
                    foreach ($newColumns as $column) {
                        $this->defineColumnType($table, $column);
                    }
                });
            }
        }

        // 5. Lakukan proses Update atau Create data (Upsert)
        $identifierColumn = $this->getIdentifierColumn($dapodikColumns, $entity);

        foreach ($dataFromDapodik as $row) {
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    $row[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
                }
            }
            
            if ($tableName === 'siswas') {
                
                // --- INI PERUBAHAN UTAMANYA ---
                // 1. Ambil data siswa yang ada, atau buat instance baru jika tidak ada.
                $siswa = Siswa::firstOrNew([
                    $identifierColumn => $row[$identifierColumn]
                ]);

                // 2. Isi data siswa dengan data DARI DAPODIK.
                // Metode fill() hanya akan mengisi kolom yang ada di $row.
                // Kolom 'foto' yang ada di database tidak akan tersentuh.
                $siswa->fill($row);
                $siswa->save();
                // --- AKHIR PERUBAHAN ---

                // Cek apakah siswa ini BARU DIBUAT dan belum punya token
                if ($siswa->wasRecentlyCreated && is_null($siswa->qr_token)) {
                    $siswa->qr_token = Str::uuid()->toString();
                    $siswa->save();
                }
            } else {
                // Untuk tabel lain, gunakan metode yang sudah ada
                DB::table($tableName)->updateOrInsert(
                    [$identifierColumn => $row[$identifierColumn]],
                    $row
                );
            }
        }
            // --- AKHIR BAGIAN YANG DIPERBARUI ---
        

        return response()->json([
            'success' => true,
            'message' => 'Sinkronisasi ' . ucfirst($entity) . ' selesai.',
            'details' => count($dataFromDapodik) . ' data berhasil diproses.'
        ]);
    }

    /**
     * Helper untuk menebak kolom mana yang menjadi Primary Key dari Dapodik
     */
    private function getIdentifierColumn(array $columns, string $entity)
    {
        // Daftar prioritas kolom ID unik dari Dapodik
        $identifiers = [
            'peserta_didik_id',
            'gtk_id',
            'sekolah_id',
            'rombongan_belajar_id',
            'pengguna_id',

        ];

        foreach ($identifiers as $id) {
            if (in_array($id, $columns)) {
                return $id;
            }
        }

        // Fallback jika tidak ada, gunakan ID unik entitas (misal: 'siswa_id')
        $fallbackId = Str::snake($entity) . '_id';
        if(in_array($fallbackId, $columns)) {
            return $fallbackId;
        }

        // Jika semua gagal, asumsikan kolom pertama adalah ID (sangat berisiko)
        return $columns[0];
    }

    /**
     * Helper untuk mendefinisikan tipe kolom secara dinamis.
     */
    private function defineColumnType($table, string $column)
    {
        if (Str::endsWith($column, '_id_str')) {
            $table->text($column)->nullable();
        } elseif (Str::endsWith($column, '_id')) {
            $table->string($column, 191)->nullable()->index(); // Gunakan string dengan index
        } elseif (str_contains($column, 'tanggal')) {
            $table->date($column)->nullable();
        } else {
            $table->text($column)->nullable();
        }
    }
}
