<div class="modal fade" id="modalInputPelanggaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Pelanggaran Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.indisipliner.siswa.daftar.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="IDkelas">Kelas <span class="text-danger">*</span></label>
                            <select name="rombel_id" id="IDkelas" class="form-select" required>
                                <option value="">- Pilih Kelas -</option>
                                @foreach($rombels as $rombel)
                                    <option value="{{ $rombel->id }}">{{ $rombel->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="NIS">Siswa <span class="text-danger">*</span></label>
                            <select name="NIS" id="NIS" class="form-select" required disabled>
                                <option value="">- Pilih Kelas Terlebih Dahulu -</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="poin_id">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select name="poin_id" id="poin_id" class="form-select" required>
                                <option value="">- Pilih Pelanggaran -</option>
                                @foreach($poins as $poin)
                                    <option value="{{ $poin->id }}" data-poin="{{ $poin->poin }}">{{ $poin->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="poin">Poin <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="poin" name="poin" readonly required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jam">Waktu <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="jam" name="jam" value="{{ date('H:i') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Script untuk modal (auto-load poin)
document.addEventListener('DOMContentLoaded', function() {
    const poinSelect = document.getElementById('poin_id');
    const poinInput = document.getElementById('poin');

    if (poinSelect && poinInput) {
        poinSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const poinValue = selectedOption.getAttribute('data-poin');
            poinInput.value = poinValue || '';
        });
    }
});
</script>