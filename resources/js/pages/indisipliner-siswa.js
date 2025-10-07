// Import library yang dibutuhkan
import $ from 'jquery';
import 'select2';

// Import CSS untuk Select2 (Vite akan menanganinya)
import 'select2/dist/css/select2.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css';

// Jalankan kode setelah halaman siap
$(document).ready(function() {
    // SEMUA KODE JAVASCRIPT ANDA YANG SEBELUMNYA ADA DI BLADE PINDAH KE SINI
    
    // Inisialisasi Select2 untuk Filter
    $('#rombel_id_filter, #nis_filter').select2({
        theme: "bootstrap-5",
        placeholder: "- Pilih -",
    });

    // Inisialisasi Select2 untuk Modal
    $('#modalInputPelanggaran .form-select').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalInputPelanggaran'),
        placeholder: "- Pilih -",
    });

    function loadSiswa(rombelID, nisSelect, selectedNis, placeholder) {
        nisSelect.prop('disabled', true).html(`<option value="">- ${placeholder} -</option>`).select2();
        if (rombelID) {
            nisSelect.html('<option value="">- Memuat Siswa... -</option>').select2();
            $.ajax({
                // PENTING: Gunakan path absolut di sini karena ini file JS murni
                url: `/admin/indisipliner-siswa/get-siswa-by-rombel/${rombelID}`,
                type: "GET", 
                dataType: "json",
                success: function(data) {
                    nisSelect.prop('disabled', false).empty().append('<option value="">- Semua Siswa -</option>');
                    $.each(data, function(key, value) {
                        var selected = (value.nipd == selectedNis) ? 'selected' : '';
                        nisSelect.append(`<option value="${value.nipd}" ${selected}>${value.nama}</option>`);
                    });
                    nisSelect.val(selectedNis).trigger('change');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    nisSelect.html('<option value="">- Gagal Memuat -</option>').select2();
                }
            });
        }
    }

    // Karena kode ini bergantung pada request Laravel, kita perlu mengambil nilainya dari elemen HTML
    var initialRombelID = $('#rombel_id_filter').val();
    // Untuk initialNis, kita bisa tambahkan data attribute di elemen select
    var initialNis = $('#nis_filter').data('initial-nis') || null; 

    if (initialRombelID) {
        loadSiswa(initialRombelID, $('#nis_filter'), initialNis, "Pilih Kelas Dulu");
    }

    $('#rombel_id_filter').on('change', function() {
        loadSiswa($(this).val(), $('#nis_filter'), null, "Semua Siswa");
    });

    // Logika untuk form di dalam modal
    $('#IDkelas').on('change', function() {
        var rombelID = $(this).val();
        var nisSelect = $('#NIS');
        if (rombelID) {
            nisSelect.prop('disabled', true).html('<option value="">- Memuat Siswa... -</option>').select2();
             $.ajax({
                url: `/admin/indisipliner-siswa/get-siswa-by-rombel/${rombelID}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    nisSelect.prop('disabled', false).empty().append('<option value="">- Pilih Siswa -</option>');
                    $.each(data, function(key, value) {
                        nisSelect.append(`<option value="${value.nipd}">${value.nama} (${value.nipd})</option>`);
                    });
                    nisSelect.trigger('change');
                }
            });
        } else {
             nisSelect.html('<option value="">- Pilih Kelas Terlebih Dahulu -</option>').prop('disabled', true).select2();
        }
    });

    // Inisialisasi Tooltip (jika Bootstrap sudah di-import global)
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl) });
    }

    // Konfirmasi Hapus
    // Event delegation lebih aman untuk elemen yang dinamis
    $(document).on('submit', '.form-delete', function(event) {
        event.preventDefault();
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) { 
            this.submit(); 
        }
    });
});