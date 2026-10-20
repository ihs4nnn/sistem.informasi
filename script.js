// ==========================================
// 1. Fungsi Toast Notification (Melayang)
// ==========================================
function showToast(message, type = 'success') {
    // Cek apakah container sudah ada, jika belum buat baru
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    // Buat elemen toast
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    // Set ikon berdasarkan tipe
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-info-circle';
    
    toast.innerHTML = `
        <i class="fas ${iconClass}"></i>
        <span style="font-weight: 500; font-size: 0.95rem;">${message}</span>
    `;
    
    container.appendChild(toast);

    // Animasi masuk (sedikit delay agar transisi jalan)
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);

    // Hilangkan toast secara otomatis setelah 3.5 detik
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 400); // Tunggu animasi keluar selesai sebelum dihapus dari DOM
    }, 3500);
}

// ==========================================
// 2. Fungsi Custom Modal Konfirmasi Hapus
// ==========================================
let deleteUrl = ""; // Menyimpan URL ID yang akan dihapus

// Fungsi ini menggantikan window.confirm() bawaan browser
function konfirmasiHapus(id) {
    deleteUrl = "hapus.php?id=" + id; // Simpan tujuan link
    const modal = document.getElementById('delete-modal');
    modal.classList.add('show');
}

// Tutup modal jika klik 'Batal'
function tutupModal() {
    deleteUrl = "";
    const modal = document.getElementById('delete-modal');
    modal.classList.remove('show');
}

// Eksekusi penghapusan jika klik 'Ya, Hapus'
function prosesHapus() {
    if (deleteUrl !== "") {
        window.location.href = deleteUrl;
    }
}