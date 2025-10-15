<div class="modal fade" id="modalInputPelanggaran" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header text-white">
        <h5 class="modal-title">
          <i class="bx bx-error-circle me-2"></i> Formulir Pelanggaran Guru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('admin.indisipliner.guru.daftar.store') }}" method="POST" id="formPelanggaranGuru">
        @csrf
        <div class="modal-body">
          <div class="row">
            {{-- Kolom Kiri --}}
            <div class="col-md-6">
              
              {{-- Tahun Pelajaran & Semester (otomatis aktif) --}}
              <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Pelajaran - Semester</label>
                <input type="text" 
                       class="form-control bg-light fw-semibold" 
                       value="@php 
                         $tahun = substr($semesterAktif, 0, 4);
                         $sem = substr($semesterAktif, 4, 1);
                         echo $tahun . '/' . ($tahun + 1) . ' - ' . ($sem == '1' ? 'Ganjil' : 'Genap');
                       @endphp"
                       readonly>
                {{-- hidden agar tetap terkirim --}}
                <input type="hidden" name="semester_id" value="{{ $semesterAktif }}">
              </div>

              {{-- Tanggal --}}
              <div class="mb-3">
                <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control"
                       value="{{ date('Y-m-d') }}" required>
              </div>

              {{-- Jam --}}
              <div class="mb-3">
                <label for="jam" class="form-label fw-semibold">Waktu</label>
                <input type="time" name="jam" id="jam" class="form-control"
                       value="{{ date('H:i') }}" required>
              </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-6">
              {{-- Guru --}}
              <div class="mb-3">
                <label for="nip" class="form-label fw-semibold">Guru</label>
                <select name="nip" id="nip" class="form-select select2">
                  <option value="">- Pilih Guru -</option>
                  @foreach ($gurus as $guru)
                    <option value="{{ $guru->nip }}">
                      {{ $guru->nama }} {{ $guru->nip ? "($guru->nip)" : '' }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Jenis Pelanggaran --}}
              <div class="mb-3">
                <label for="IDpelanggaran_poin" class="form-label fw-semibold">Poin - Jenis Pelanggaran</label>
                <select name="IDpelanggaran_poin" id="IDpelanggaran_poin" class="form-select select2" required>
                  <option value="">- Pilih Jenis Pelanggaran -</option>
                  @foreach ($kategoriList as $kategori)
                    <optgroup label="{{ strtoupper($kategori->nama) }}">
                      @foreach ($kategori->pelanggaranPoinGtk as $poin)
                        <option value="{{ $poin->ID }}">
                          {{ $poin->nama }} ({{ $poin->poin }} Poin)
                        </option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer bg-light d-flex justify-content-end">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bx bx-x me-1"></i> Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
  $('#modalInputPelanggaran .select2').select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#modalInputPelanggaran'),
    placeholder: '- Pilih -',
    width: '100%'
  });
});
</script>
@endpush
