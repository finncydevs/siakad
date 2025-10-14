import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// =================================================================
// ==> BAGIAN PALING PENTING ADA DI SINI <==
// 1. Import JQuery dari path tema Sneat Anda dan tampung dalam variabel `$`.
// import $ from '~sneat/vendor/libs/jquery/jquery.js';

// 2. Jadikan variabel `$` tersebut global agar bisa diakses di mana saja.
window.jQuery = window.$ = $;
// =================================================================

// Lanjutkan dengan import sisa file Sneat Vendor JS
import '~sneat/vendor/libs/popper/popper.js';
import '~sneat/vendor/js/bootstrap.js';
import '~sneat/vendor/libs/perfect-scrollbar/perfect-scrollbar.js';
import '~sneat/vendor/js/helpers.js';
import '~sneat/vendor/js/menu.js';
import '~sneat/vendor/libs/apex-charts/apexcharts.js';

// Import Select2 dan temanya
import 'select2';
import 'select2/dist/css/select2.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css';

// Import sisa file Sneat Core JS
import '~sneat/js/main.js';
import '~sneat/js/dashboards-analytics.js';
import '~sneat/js/ui-modals.js';
import '~sneat/js/ui-toasts.js';