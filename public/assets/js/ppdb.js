
            // Import Modul Firebase
            import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
            import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
            import { getFirestore, collection, onSnapshot, addDoc, doc, setDoc } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";
            import { setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

            // Global variables provided by Canvas environment
            const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
            const firebaseConfig = typeof __firebase_config !== 'undefined' ? JSON.parse(__firebase_config) : null;
            const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;

            let db;
            let auth;
            let currentUserId = null;
            let isAuthReady = false;

            // Firestore path untuk koleksi pendaftar (Public Data)
            const REGISTRATION_COLLECTION_PATH = `artifacts/${appId}/public/data/registrations`;

            // Data langkah-langkah formulir BARU (5 langkah total)
            const STEPS = [
                { id: 1, title: 'Data Diri', name: 'data-diri' },
                { id: 2, title: 'Data Sekolah', name: 'data-sekolah' },
                { id: 3, title: 'Pilih Jurusan', name: 'pilih-jurusan' },
                { id: 4, title: 'Upload Persyaratan', name: 'upload-dokumen' },
                { id: 5, title: 'Selesai', name: 'selesai' }
            ];

            // Data Jurusan SMAKNIS dan Peta Jurusan untuk display tabel
            const JURUSAN = [
                { value: "PPLG", text: "PPLG - Pengembangan Perangkat Lunak dan GIM" },
                { value: "TJKT", text: "TJKT - Teknik Jaringan Komputer dan Telekomunikasi" },
                { value: "AKL", text: "AKL - Akuntansi dan Keuangan Lembaga" },
                { value: "DKV", text: "DKV - Desain Komunikasi Visual" },
                { value: "MPLB", text: "MPLB - Manajemen Perkantoran dan Layanan Bisnis" },
                { value: "Otomotif", text: "Otomotif - Teknik Otomotif" }
            ];

            const JURUSAN_MAP = {
                "PPLG": "PPLG (Pengembangan Perangkat Lunak)",
                "TJKT": "TJKT (Teknik Jaringan Komputer)",
                "AKL": "AKL (Akuntansi dan Keuangan)",
                "DKV": "DKV (Desain Komunikasi Visual)",
                "MPLB": "MPLB (Manajemen Perkantoran)",
                "Otomotif": "Otomotif (Teknik Otomotif)"
            };

            let currentStep = 1;
            const totalSteps = STEPS.length;
            let formData = {};

            // Elemen-elemen DOM
            const stepIndicatorsEl = document.getElementById('stepIndicators');
            const formContentEl = document.getElementById('formContent');
            const progressBarEl = document.getElementById('progressBar');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            const ppdbForm = document.getElementById('ppdb-form');
            const notification = document.getElementById('notification');
            const userIdDisplayEl = document.getElementById('user-id-display');

            // Elemen untuk daftar siswa
            const tableContainerEl = document.getElementById('applicants-table-container');

            // Elemen dan Fungsi untuk Active Link Highlighting
            const sections = document.querySelectorAll('section[id]');
            const navLinksDesktop = document.querySelectorAll('.nav-link-desktop');
            const navLinksMobile = document.querySelectorAll('.nav-link-mobile');


            /**
             * Memperbarui tautan navigasi agar aktif sesuai dengan section yang sedang terlihat.
             */
            function updateActiveLink() {
                const currentUrl = window.location.href;
                let currentSectionId = 'beranda'; // Default ke Beranda
                        
                // --- Jika sedang di halaman route lain (bukan yang pakai #section) ---
                if (!currentUrl.includes('#')) {
                    // Cek apakah URL cocok dengan salah satu link di navbar
                    navLinksDesktop.forEach(link => {
                        link.classList.remove('nav-link-desktop-active');
                    
                        const linkHref = link.href;
                        // Kalau URL sekarang sama dengan link-nya
                        if (currentUrl === linkHref || currentUrl.startsWith(linkHref)) {
                            link.classList.add('nav-link-desktop-active');
                        }
                    });
                
                    navLinksMobile.forEach(link => {
                        link.classList.remove('nav-link-mobile-active');
                    
                        const linkHref = link.href;
                        if (currentUrl === linkHref || currentUrl.startsWith(linkHref)) {
                            link.classList.add('nav-link-mobile-active');
                        }
                    });
                
                    // Hentikan fungsi di sini (biar nggak lanjut scroll spy)
                    return;
                }
            
                // --- Kalau URL pakai anchor (#), jalankan logika scroll spy seperti biasa ---
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 150) {
                        currentSectionId = section.getAttribute('id');
                    }
                });
            
                // --- Terapkan Kelas Aktif untuk Desktop ---
                navLinksDesktop.forEach(link => {
                    link.classList.remove('nav-link-desktop-active');
                    if (link.getAttribute('href').includes(currentSectionId)) {
                        link.classList.add('nav-link-desktop-active');
                    }
                });
            
                // --- Terapkan Kelas Aktif untuk Mobile ---
                navLinksMobile.forEach(link => {
                    link.classList.remove('nav-link-mobile-active');
                    if (link.getAttribute('href').includes(currentSectionId)) {
                        link.classList.add('nav-link-mobile-active');
                    }
                });
            }



            // ======================= FIREBASE DAN LOGIKA DAFTAR SISWA =======================

            /**
             * Merender tabel pendaftar dari data Firestore.
             */
            function renderApplicantsTable(applicants) {
                if (!tableContainerEl) return;

                if (applicants.length === 0) {
                    tableContainerEl.innerHTML = `
                    <div class="text-center py-10 bg-white rounded-xl shadow-md border-b-4 border-secondary-green">
                        <i data-lucide="info" class="w-8 h-8 text-primary-blue mx-auto mb-3"></i>
                        <p class="text-xl font-semibold text-gray-700">Belum ada pendaftar.</p>
                        <p class="text-gray-500">Ayo segera daftar dan muncul di daftar ini!</p>
                    </div>
                `;
                    lucide.createIcons();
                    return;
                }

                let tableHtml = `
                <div class="overflow-x-auto bg-white rounded-xl shadow-2xl shadow-primary-blue/20 border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-blue text-white">
                            <tr>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-left">No. Urut</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-left">No. Pendaftaran</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-left">NISN</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-left">Nama Lengkap</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-left">Asal Sekolah</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-left">Jurusan Dipilih</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
            `;

                applicants.forEach((data, index) => {
                    const rowClass = index % 2 === 0 ? 'bg-gray-50' : 'bg-white';
                    const sequentialNumber = index + 1;
                    // Generate synthetic registration number: PPDB24-0001, PPDB24-0002, dst.
                    const registrationNumber = `PPDB26-${String(sequentialNumber).padStart(4, '0')}`;

                    const jurusanText = JURUSAN_MAP[data['jurusan-minat']] || data['jurusan-minat'] || '-';
                    const nisnDisplay = data['nisn'] || '-';
                    const namaDisplay = data['nama-lengkap'] || 'Nama Pendaftar';
                    const asalSekolahDisplay = data['asal-sekolah'] || '-';


                    tableHtml += `
                    <tr class="${rowClass} hover:bg-yellow-50/50 transition duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${sequentialNumber}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-primary-blue">${registrationNumber}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">${nisnDisplay}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-700">${namaDisplay}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">${asalSekolahDisplay}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-green">${jurusanText}</td>
                    </tr>
                `;
                });

                tableHtml += `
                        </tbody>
                    </table>
                </div>
                <p class="text-sm text-gray-500 mt-6 text-center">Total Pendaftar Saat Ini: <span class="font-bold text-lg text-primary-blue">${applicants.length}</span></p>
                <p class="text-xs text-gray-400 mt-1 text-center">Data diperbarui secara real-time dari database.</p>
            `;

                tableContainerEl.innerHTML = tableHtml;
            }

            /**
             * Memulai listener Firestore untuk mengambil daftar dokumen pendaftar secara real-time.
             */
            function startRegistrationListener() {
                if (!db || !isAuthReady) return;

                const registrationsRef = collection(db, REGISTRATION_COLLECTION_PATH);

                // onSnapshot digunakan untuk mendengarkan perubahan data secara real-time
                onSnapshot(registrationsRef, (snapshot) => {
                    const applicants = [];
                    snapshot.forEach((doc) => {
                        const data = doc.data();
                        // Hanya tampilkan pendaftar yang memiliki data kunci (nama, nisn, jurusan)
                        if (data['nama-lengkap'] && data['nisn'] && data['jurusan-minat']) {
                            // Tambahkan data pendaftaran dan ID dokumen
                            applicants.push({ ...data, id: doc.id });
                        }
                    });

                    // Urutkan berdasarkan timestamp pendaftaran (jika tersedia), default urutan dokumen
                    applicants.sort((a, b) => {
                        // Jika ada timestamp Firestore, gunakan itu
                        const timeA = a.timestamp ? a.timestamp.toDate().getTime() : 0;
                        const timeB = b.timestamp ? b.timestamp.toDate().getTime() : 0;
                        return timeA - timeB;
                    });

                    console.log(`[Firestore] Total Pendaftar yang valid: ${applicants.length}`);

                    // Render tabel dengan data pendaftar
                    renderApplicantsTable(applicants);

                }, (error) => {
                    console.error("[Firestore] Error fetching applicant list:", error);
                    if (tableContainerEl) {
                        tableContainerEl.innerHTML = '<p class="text-red-500 text-center py-5">Gagal memuat daftar pendaftar. Cek koneksi Anda.</p>';
                    }
                });
            }

            /**
             * Fungsi untuk menambah dokumen registrasi baru saat form disubmit.
             */
            window.saveRegistration = async function (data) {
                if (!db || !isAuthReady) {
                    showNotification('Database belum siap. Coba lagi sebentar.', true);
                    return false;
                }

                try {
                    // Tambahkan data registrasi
                    await addDoc(collection(db, REGISTRATION_COLLECTION_PATH), {
                        ...data,
                        timestamp: new Date(),
                        userId: currentUserId
                    });
                    return true;
                } catch (error) {
                    console.error("[Firestore] Error saving registration:", error);
                    showNotification('Gagal menyimpan pendaftaran ke database. Cek koneksi dan perizinan.', true);
                    return false;
                }
            }

            /**
             * Menginisialisasi Firebase, melakukan autentikasi, dan mendengarkan daftar pendaftar.
             */
            async function initFirebaseAndFetchCount() {
                setLogLevel('debug');
                if (!firebaseConfig) {
                    console.error("Firebase config is missing. Cannot initialize Firestore features.");
                    return;
                }

                const app = initializeApp(firebaseConfig);
                db = getFirestore(app);
                auth = getAuth(app);

                // 1. Autentikasi Anonim atau dengan Token Kustom
                try {
                    if (initialAuthToken) {
                        await signInWithCustomToken(auth, initialAuthToken);
                    } else {
                        await signInAnonymously(auth);
                    }
                } catch (error) {
                    console.error("Authentication failed:", error);
                }

                // 2. Listener Auth State
                onAuthStateChanged(auth, (user) => {
                    currentUserId = user ? user.uid : crypto.randomUUID();
                    isAuthReady = true;
                    console.log("[Auth] State Changed. User ID:", currentUserId);

                    if (userIdDisplayEl) {
                        userIdDisplayEl.textContent = currentUserId;
                    }

                    // Mulai mendengarkan daftar pendaftar setelah otentikasi siap
                    startRegistrationListener();
                });
            }

            // ======================= LOGIKA FORM DAN UI =======================

            /**
             * Fungsi utilitas untuk menampilkan notifikasi kustom.
             */
            function showNotification(message, isError = false) {
                notification.classList.remove('bg-secondary-green', 'bg-red-500');
                notification.classList.add(isError ? 'bg-red-500' : 'bg-secondary-green');

                // Set ikon dan pesan
                const iconHtml = `<i data-lucide="${isError ? 'x-octagon' : 'check-circle'}" class="w-6 h-6"></i>`;
                notification.innerHTML = `${iconHtml}<span id="notification-message">${message}</span>`;

                notification.classList.add('show');
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 5000);
                lucide.createIcons();
            }

            /**
             * Mengambil data input dari langkah yang baru saja ditinggalkan.
             */
            function collectFormData() {
                const inputs = formContentEl.querySelectorAll('[name]');
                inputs.forEach(input => {
                    if (input.type === 'file') {
                        // Simpan nama file atau status ada/tidaknya file yang sudah di-upload
                        formData[input.name] = input.files.length > 0 ? input.files[0].name : (formData[input.name] || '');
                    } else {
                        formData[input.name] = input.value;
                    }
                });
            }

            /**
             * Mengisi kembali form input berdasarkan data yang tersimpan di `formData`.
             */
            function restoreFormData() {
                const inputs = formContentEl.querySelectorAll('[name]');
                inputs.forEach(input => {
                    if (formData[input.name] !== undefined) {
                        // Hanya mengisi input non-file
                        if (input.type !== 'file') {
                            input.value = formData[input.name];
                        }
                    }
                });
            }

            /**
             * Validasi input wajib pada langkah saat ini.
             */
            function validateStep(stepId) {
                const requiredInputs = formContentEl.querySelectorAll('[required]');
                let valid = true;
                let errorMessages = [];

                // Helper function to mark input as invalid
                const markInvalid = (input) => {
                    valid = false;
                    input.classList.add('border-red-500', 'ring-2', 'ring-red-500/50');
                };

                // Remove previous error markings
                requiredInputs.forEach(input => {
                    input.classList.remove('border-red-500', 'ring-2', 'ring-red-500/50');
                });

                // 1. Check for empty required fields
                requiredInputs.forEach(input => {
                    if (input.type === 'file') {
                        // Cek jika input file wajib dan belum ada file yang dipilih atau sudah tersimpan
                        const isAlreadyUploaded = formData[input.name] && formData[input.name] !== '';
                        const isRequiredAndEmpty = input.hasAttribute('required') && input.files.length === 0 && !isAlreadyUploaded;

                        if (isRequiredAndEmpty) {
                            markInvalid(input);
                            if (!errorMessages.includes('Mohon lengkapi semua kolom bertanda *.')) {
                                errorMessages.push('Mohon lengkapi semua kolom bertanda *.');
                            }
                        }
                    } else if (input.value.trim() === "" || (input.tagName === 'SELECT' && input.value === "")) {
                        markInvalid(input);
                        if (!errorMessages.includes('Mohon lengkapi semua kolom bertanda *.')) {
                            errorMessages.push('Mohon lengkapi semua kolom bertanda *.');
                        }
                    }
                });

                // If required fields are missing, stop here
                if (!valid) {
                    showNotification(errorMessages[0] || `Mohon lengkapi semua kolom bertanda * di langkah ${stepId}.`, true);
                    return false;
                }

                // 2. Perform specific validation based on the step
                if (stepId === 1) { // Data Diri
                    const nisnInput = formContentEl.querySelector('#nisn');
                    const waInput = formContentEl.querySelector('#kontak-wa');

                    // Validate NISN (10 digits, numbers only)
                    if (nisnInput && nisnInput.value.trim().length > 0) {
                        const nisnValue = nisnInput.value.trim();
                        if (!/^\d{10}$/.test(nisnValue)) {
                            markInvalid(nisnInput);
                            errorMessages.push('NISN harus tepat 10 digit angka.');
                        }
                    }

                    // Validate WhatsApp Number (min 10 digits, numbers only)
                    if (waInput && waInput.value.trim().length > 0) {
                        const waValue = waInput.value.trim();
                        if (!/^\d{10,}$/.test(waValue)) {
                            markInvalid(waInput);
                            errorMessages.push('Nomor WhatsApp tidak valid. Masukkan minimal 10 digit angka.');
                        }
                    }
                }

                // Show combined specific error message if any, or default error if only general required error
                if (errorMessages.length > 0) {
                    // If there are specific errors, show the first specific error
                    const specificError = errorMessages.find(msg => msg !== 'Mohon lengkapi semua kolom bertanda *.');
                    if (specificError) {
                        showNotification(specificError, true);
                        return false;
                    }
                    // If only the general required error exists, show it
                    showNotification(errorMessages[0], true);
                    return false;
                }

                return valid;
            }

            /**
             * Merender semua lingkaran indikator langkah pada progress bar.
             */
            function renderStepIndicators() {
                stepIndicatorsEl.innerHTML = '';
                // Render 5 lingkaran untuk 5 langkah
                STEPS.forEach(step => {
                    const isCompleted = step.id < currentStep;
                    const isActive = step.id === currentStep;

                    let circleClasses = 'w-10 h-10 flex items-center justify-center rounded-full text-white font-bold text-sm z-10 step-circle';
                    let titleClasses = 'text-xs mt-3 w-max text-center absolute left-1/2 transform -translate-x-1/2 transition duration-300 ease-in-out';

                    if (isCompleted) {
                        circleClasses += ' bg-secondary-green scale-110';
                        titleClasses += ' text-secondary-green font-semibold';
                    } else if (isActive) {
                        circleClasses += ' bg-primary-blue ring-4 ring-primary-blue/30 scale-110';
                        titleClasses += ' text-primary-blue font-bold';
                    } else {
                        circleClasses += ' bg-gray-400/70 text-gray-100';
                        titleClasses += ' text-gray-500';
                    }

                    const stepEl = document.createElement('div');
                    stepEl.className = 'relative flex-1 text-center';

                    // Elemen lingkaran indikator
                    const circleEl = document.createElement('div');
                    circleEl.className = circleClasses + ' cursor-default mx-auto';

                    // Menggunakan ikon centang jika langkah selesai
                    circleEl.innerHTML = isCompleted ? `<i data-lucide="check" class="w-5 h-5"></i>` : step.id;

                    // Teks judul di bawah lingkaran (hanya 2 kata pertama)
                    const subTitleEl = document.createElement('span');
                    subTitleEl.className = titleClasses;
                    const stepTitleShort = step.title.split(' ')[0] + ' ' + (step.title.split(' ')[1] || '');
                    subTitleEl.textContent = stepTitleShort.trim();
                    subTitleEl.style.top = '56px';

                    stepEl.appendChild(circleEl);
                    stepEl.appendChild(subTitleEl);
                    stepIndicatorsEl.appendChild(stepEl);
                });
                lucide.createIcons();
            }

            /**
             * Menghasilkan HTML untuk input form.
             */
            function createInput(type, id, label, placeholder, required = false, options = []) {
                const requiredHtml = required ? `<span class="text-red-500">*</span>` : '';

                let inputHtml = '';
                let fileStatusHtml = '';

                const inputClasses = "w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary-blue focus:border-primary-blue transition duration-200";

                // Cek apakah data file sudah tersimpan
                const isAlreadyUploaded = formData[id] && formData[id] !== '';

                if (type === 'select') {
                    inputHtml = `
                    <select id="${id}" name="${id}" ${required ? 'required' : ''}
                            class="${inputClasses} appearance-none bg-white">
                        <option value="">${placeholder}</option>
                        ${options.map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                    </select>
                `;
                } else if (type === 'textarea') {
                    inputHtml = `
                    <textarea id="${id}" name="${id}" rows="3" ${required ? 'required' : ''}
                        class="${inputClasses}" placeholder="${placeholder}"></textarea>
                `;
                } else if (type === 'file') {
                    if (isAlreadyUploaded) {
                        fileStatusHtml = `<p class="text-xs text-secondary-green mt-1 flex items-center"><i data-lucide="file-check" class="w-4 h-4 mr-1"></i> File saat ini: ${formData[id]} (Ganti file untuk update)</p>`;
                    }

                    inputHtml = `
                    <input type="file" id="${id}" name="${id}" accept=".pdf,image/*" ${required && !isAlreadyUploaded ? 'required' : ''}
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-blue focus:border-primary-blue transition duration-200 bg-white">
                           ${fileStatusHtml}
                 `;
                }
                else {
                    inputHtml = `
                    <input type="${type}" id="${id}" name="${id}" ${required ? 'required' : ''}
                        class="${inputClasses}" placeholder="${placeholder}">
                `;
                }

                return `
                <div>
                    <label for="${id}" class="block text-sm font-medium text-gray-700 mb-2">${label} ${requiredHtml}</label>
                    ${inputHtml}
                </div>
            `;
            }

            /**
             * Merender konten HTML untuk langkah formulir tertentu.
             */
            function renderFormStep(stepId) {
                const currentStepData = STEPS[stepId - 1];

                let htmlContent = '';
                let description = '';

                // Data untuk pilihan Kelas
                const classOptions = ['IX A', 'IX B', 'IX C', 'IX D', 'IX E', 'IX F'].map(cls => ({ value: cls, text: cls }));


                if (currentStepData.name === 'data-diri') {
                    // Langkah 1
                    description = 'Silakan isi informasi pribadi Anda seperti Nama, Tempat/Tanggal Lahir, Kontak, dan Alamat Domisili.';
                    htmlContent = `
                    <div class="space-y-6">
                        ${createInput('text', 'nama-lengkap', 'Nama Lengkap Calon Siswa', 'Masukkan nama lengkap siswa', true)}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${createInput('text', 'tempat-lahir', 'Tempat Lahir', 'Contoh: Jakarta', true)}
                            ${createInput('date', 'tanggal-lahir', 'Tanggal Lahir', '', true)}
                        </div>
                        ${createInput('textarea', 'alamat', 'Alamat Lengkap (Domisili)', 'Masukkan alamat lengkap siswa saat ini', true)}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${createInput('select', 'jenis-kelamin', 'Jenis Kelamin', '-- Pilih Jenis Kelamin --', true, [
                        { value: 'Laki-laki', text: 'Laki-laki' },
                        { value: 'Perempuan', text: 'Perempuan' }
                    ])}
                            ${createInput('number', 'nisn', 'NISN', 'Nomor Induk Siswa Nasional (10 Digit)', true)}
                        </div>
                        ${createInput('tel', 'kontak-wa', 'Nomor HP/WhatsApp (Aktif)', 'Contoh: 081234567890', true)}
                        <p class="text-sm text-gray-500 pt-2 border-t border-gray-200">Data Orang Tua (Opsional, disarankan):</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${createInput('text', 'nama-ayah', 'Nama Lengkap Ayah', 'Nama lengkap ayah/wali')}
                            ${createInput('text', 'nama-ibu', 'Nama Lengkap Ibu', 'Nama lengkap ibu/wali')}
                        </div>
                    </div>
                `;
                } else if (currentStepData.name === 'data-sekolah') {
                    // Langkah 2 (Dipisah dari Pilihan Jurusan) - Alamat sudah dipindah
                    description = 'Masukkan informasi asal sekolah dan detail pendaftaran awal Anda.';
                    htmlContent = `
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${createInput('text', 'asal-sekolah', 'Asal Sekolah', 'Contoh: SMP Negeri 1', true)}
                            ${createInput('select', 'kelas', 'Kelas Terakhir/Saat Ini', '-- Pilih Kelas Terakhir --', true, classOptions)}
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${createInput('select', 'ukuran-baju', 'Ukuran Baju Seragam', '-- Pilih Ukuran Baju (Untuk Data Seragam) --', true, [
                        { value: 'S', text: 'S' }, { value: 'M', text: 'M' }, { value: 'L', text: 'L' },
                        { value: 'XL', text: 'XL' }, { value: 'XXL', text: 'XXL' }, { value: 'XXXL', text: 'XXXL' }
                    ])}
                            ${createInput('select', 'jalur-pendaftaran', 'Jalur Pendaftaran', '-- Pilih Jalur Pendaftaran --', true, [
                        { value: 'Reguler', text: 'Reguler' },
                        { value: 'Prestasi', text: 'Prestasi (Rapor/Akademik/Non-Akademik)' },
                        { value: 'Afirmasi', text: 'Afirmasi (KIP/KKS)' },
                        { value: 'Perpindahan', text: 'Perpindahan Tugas Orang Tua' }
                    ])}
                        </div>
                    </div>
                `;
                } else if (currentStepData.name === 'pilih-jurusan') {
                    // Langkah 3 (Dipisah dari Data Sekolah)
                    description = 'Pilih satu kompetensi keahlian yang paling Anda minati di SMAKNIS.';
                    htmlContent = `
                    <div class="space-y-6">
                        ${createInput('select', 'jurusan-minat', 'Pilihan Utama Jurusan', '-- Pilih Jurusan Pilihan Utama --', true, JURUSAN)}
                        <p class="text-sm text-gray-500 pt-2 border-t border-gray-200">Memilih jurusan yang sesuai minat akan meningkatkan peluang karir Anda setelah lulus.</p>
                    </div>
                `;
                } else if (currentStepData.name === 'upload-dokumen') {
                    // Langkah 4
                    description = 'Unggah semua dokumen persyaratan pendaftaran. Dokumen wajib adalah Kartu Keluarga.';
                    htmlContent = `
                    <div class="space-y-6">
                        <div class="p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-700 mb-4 font-semibold">
                                Dokumen wajib ditandai <span class="text-red-500">*</span>. Ukuran maksimum per file adalah 1MB (Format PDF atau Gambar).
                            </p>
                            ${createInput('file', 'upload-kk', 'Unggah Scan Kartu Keluarga', 'Pilih file Kartu Keluarga', true)}
                            ${createInput('file', 'upload-rapor', 'Unggah Foto Rapor SMP/MTS (Semester Akhir)', 'Pilih file rapor (Opsional)')}
                            ${createInput('file', 'upload-sertifikat', 'Unggah Sertifikat Prestasi (Jika ada)', 'Pilih file sertifikat (Opsional)')}
                        </div>
                    </div>
                `;
                } else if (currentStepData.name === 'selesai') {
                    // Langkah 5
                    description = 'Anda telah melengkapi semua data. Klik tombol "Kirim Pendaftaran" di bawah untuk menyelesaikan proses.';
                    htmlContent = `
                    <div class="text-center py-10">
                        <i data-lucide="send-check" class="w-16 h-16 text-secondary-green mx-auto mb-4"></i>
                        <h3 class="text-2xl font-extrabold text-primary-blue mb-3">Pendaftaran Siap Dikirim!</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Pastikan semua data sudah benar. Setelah dikirim, Anda akan menerima konfirmasi via WhatsApp.
                        </p>
                        <div class="text-left p-4 bg-gray-100 rounded-lg max-w-sm mx-auto">
                            <p class="text-sm font-semibold text-gray-700">Ringkasan Data Utama:</p>
                            <p class="text-xs text-gray-600">Nama: ${formData['nama-lengkap'] || '-'} </p>
                            <p class="text-xs text-gray-600">Jurusan: ${JURUSAN_MAP[formData['jurusan-minat']] || '-'} </p>
                            <p class="text-xs text-gray-600">Kontak: ${formData['kontak-wa'] || '-'} </p>
                        </div>
                    </div>
                `;
                }

                // Memperbarui konten formulir
                formContentEl.innerHTML = `
                <h2 class="text-2xl font-bold text-primary-blue mb-4">Langkah ${currentStep}: ${currentStepData.title}</h2>
                <p class="text-gray-700 mb-6">${description}</p>
                <!-- Konten Form Dinamis -->
                ${htmlContent}
            `;

                restoreFormData(); // Isi kembali data yang tersimpan setelah HTML dirender
                lucide.createIcons();
            }


            /**
             * Memperbarui tampilan bilah progres dan konten formulir.
             */
            function updateProgress() {
                // Ada 4 langkah fisik untuk diisi (TotalSteps - 1)
                const progressSteps = totalSteps - 1; // 5 - 1 = 4 langkah pengisian
                // Hitung persentase berdasarkan langkah pengisian yang diselesaikan
                const progressPercentage = (currentStep === totalSteps) ? 100 : ((currentStep - 1) / (progressSteps - 1)) * 100;

                progressBarEl.style.width = `${progressPercentage}%`;

                renderStepIndicators();
                renderFormStep(currentStep);

                // Mengelola status tombol Navigasi
                prevBtn.disabled = currentStep === 1;
                prevBtn.classList.toggle('opacity-50', currentStep === 1);

                if (currentStep === totalSteps) {
                    // Langkah terakhir (Selesai)
                    nextBtn.classList.add('hidden');
                    submitBtn.classList.remove('hidden');
                } else {
                    // Langkah biasa
                    nextBtn.classList.remove('hidden');
                    submitBtn.classList.add('hidden');
                }
            }

            /**
             * Pindah ke langkah berikutnya.
             */
            window.nextStep = function () {
                if (currentStep < totalSteps) {
                    // 1. Validasi langkah saat ini
                    if (!validateStep(currentStep)) {
                        return;
                    }

                    // 2. Simpan data langkah yang baru divalidasi
                    collectFormData();

                    // 3. Pindah langkah dan scroll ke atas form
                    currentStep++;
                    updateProgress();
                    document.getElementById('daftar').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            /**
             * Pindah ke langkah sebelumnya.
             */
            window.prevStep = function () {
                if (currentStep > 1) {
                    // Simpan data langkah yang baru ditinggalkan
                    collectFormData();
                    currentStep--;
                    updateProgress();
                    document.getElementById('daftar').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            // Logika Submit Formulir (pada Langkah Terakhir)
            document.addEventListener('DOMContentLoaded', function () {
                AOS.init({ once: true, duration: 800 });
                lucide.createIcons();

                // Panggil fungsi active link saat pertama kali dimuat
                updateActiveLink();

                // Tambahkan event listener untuk scroll dan resize
                window.addEventListener('scroll', updateActiveLink);
                window.addEventListener('resize', updateActiveLink);

                // Inisialisasi Firebase dan mulai ambil daftar pendaftar
                initFirebaseAndFetchCount();

                // Inisialisasi Tampilan Form
                updateProgress();

                ppdbForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    // Dapatkan Nama dan Jurusan untuk notifikasi
                    const studentName = formData['nama-lengkap'] || 'Calon Siswa';
                    const selectedJurusanValue = formData['jurusan-minat'];
                    const selectedJurusan = JURUSAN_MAP[selectedJurusanValue] || 'Jurusan yang Dipilih';

                    // Panggil fungsi simpan ke Firestore
                    const isSaved = await window.saveRegistration(formData); // Await the save

                    if (isSaved) {
                        // Tampilkan notifikasi sukses
                        showNotification(`Terima kasih, <b>${studentName}</b>! Pendaftaran ke <b>${selectedJurusan}</b> telah berhasil dikirimkan.`, false);

                        // Reset formulir dan kembali ke langkah 1 setelah 3 detik
                        setTimeout(() => {
                            ppdbForm.reset();
                            formData = {}; // Kosongkan data
                            currentStep = 1;
                            updateProgress();
                            document.getElementById('daftar').scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 3000);
                    } else {
                        // saveRegistration sudah menampilkan error jika gagal
                    }
                });
            });
        