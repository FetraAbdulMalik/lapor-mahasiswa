# 📋 Panduan Validasi Form - Lapor Mahasiswa

## Ringkasan Perubahan
Form validasi telah ditingkatkan untuk memastikan tidak ada field kosong yang bisa diproses. Implementasi mencakup validasi **client-side** dan **server-side** untuk keamanan maksimal.

---

## ✅ Validasi pada Form Buat Laporan (`/student/reports/create`)

### Field yang Wajib Diisi:

| No | Field | Validasi | Pesan Error |
|---|---|---|---|
| 1 | **Kategori Laporan** | Harus dipilih | "Pilih kategori laporan terlebih dahulu" |
| 2 | **Judul Laporan** | Tidak boleh kosong | "Judul laporan tidak boleh kosong" |
| 3 | **Deskripsi Detail** | Min 50 karakter | "Deskripsi minimal 50 karakter" |
| 4 | **Prioritas** | Harus dipilih | "Pilih prioritas laporan" |
| 5 | **Tipe Visibilitas** | Harus dipilih | "Pilih tipe visibilitas laporan" |
| 6 | **Persetujuan Terms** | Harus dicentang | "Setujui persyaratan sebelum mengirim" |

### Fitur Validasi:

#### 1. **Client-Side Validation** (Real-time)
```javascript
- Cek kategori dipilih (radio button)
- Cek judul tidak kosong
- Cek deskripsi minimal 50 karakter
- Cek prioritas dipilih
- Cek visibilitas dipilih
- Cek terms & conditions dicentang
```

#### 2. **Error Alert**
Jika ada field yang kosong atau tidak valid:
- Tampilkan popup alert dengan daftar error
- Block form submission sampai semua field valid
- Tunjukkan nomor karakter untuk deskripsi

#### 3. **Server-Side Validation** (Security)
File: `app/Http/Controllers/Student/ReportController.php` → `store()`
```php
$validated = $request->validate([
    'category_id' => 'required|exists:report_categories,id',
    'title' => 'required|string|max:255',
    'description' => 'required|string|min:50',
    'priority' => 'required|in:low,medium,high,urgent',
    'visibility' => 'required|in:public,anonymous,private',
    // ... field lainnya
]);
```

---

## ✏️ Validasi pada Form Edit Laporan (`/student/reports/edit`)

### Field yang Wajib Diisi (sama dengan create):

| No | Field | Validasi |
|---|---|---|
| 1 | **Kategori** | Harus dipilih |
| 2 | **Judul** | Tidak boleh kosong |
| 3 | **Deskripsi** | Min 50 karakter |
| 4 | **Prioritas** | Harus dipilih |

### Perbedaan dari Create:
- Tidak perlu validasi Terms (sudah accepted saat create)
- Tidak perlu validasi Visibility (fixed dari create)
- Hanya bisa edit laporan dengan status **pending**

---

## 🚀 Cara Kerja Validasi

### 1. User Submit Form
```
User klik tombol "Kirim Laporan" / "Simpan Perubahan"
        ↓
JavaScript validateForm() dipanggil
        ↓
```

### 2. Cek Setiap Field
```
✓ Kategori dipilih?
✓ Judul tidak kosong?
✓ Deskripsi minimal 50 char?
✓ Prioritas dipilih?
✓ Visibilitas dipilih?
✓ Terms disetujui?
```

### 3. Ada Error?
```
Ada Error
  ↓
Tampilkan Alert
  ↓
Highlight Error
  ↓
Block Form Submit
  ↓
User Fix & Retry
```

### 4. Semua Valid?
```
Semua Valid
  ↓
Set isSubmitting = true
  ↓
Disable Button + Show Spinner
  ↓
Submit ke Server
  ↓
Server Validate Again (security)
  ↓
Save / Update Database
```

---

## 🔒 Security Features

### 1. Double Validation
- **Frontend**: Cepat, user-friendly
- **Backend**: Aman, tidak bisa di-bypass

### 2. Server-Side Rules
```php
// Harus sesuai dengan validasi frontend
'category_id' => 'required|exists:report_categories,id',
'title' => 'required|string|max:255',
'description' => 'required|string|min:50',
```

### 3. CSRF Protection
Semua form menggunakan Laravel CSRF token:
```blade
@csrf
```

---

## 📝 Error Messages Display

### Validasi Gagal - Tampil Alert:
```
⚠️ Mohon lengkapi form terlebih dahulu:

❌ Pilih kategori laporan terlebih dahulu
❌ Judul laporan tidak boleh kosong
❌ Deskripsi minimal 50 karakter (saat ini: 25)
❌ Pilih prioritas laporan
```

### Server Error - Tampil di Atas Form:
```
⚠️ Ada kesalahan dalam pengisian form:
• The category id field is required.
• The title field is required.
• The description must be at least 50 characters.
```

---

## 🎯 Implementasi Files

### Create Form:
- **View**: `resources/views/student/reports/create.blade.php`
- **Controller**: `app/Http/Controllers/Student/ReportController.php` → `store()`
- **Validasi JS**: Inline di bottom halaman

### Edit Form:
- **View**: `resources/views/student/reports/edit.blade.php`
- **Controller**: `app/Http/Controllers/Student/ReportController.php` → `update()`
- **Validasi JS**: Inline di bottom halaman

---

## 🧪 Testing Checklist

- [ ] Buat laporan tanpa memilih kategori → Error: "Pilih kategori"
- [ ] Buat laporan tanpa judul → Error: "Judul tidak boleh kosong"
- [ ] Buat laporan deskripsi < 50 char → Error: "Minimal 50 karakter"
- [ ] Buat laporan tanpa priority → Error: "Pilih prioritas"
- [ ] Buat laporan tanpa visibility → Error: "Pilih visibilitas"
- [ ] Buat laporan tanpa setuju terms → Error: "Setujui persyaratan"
- [ ] Isi semua field dengan benar → Submit berhasil
- [ ] Edit laporan dengan field kosong → Error validation
- [ ] Edit laporan dengan data valid → Update berhasil

---

## 📚 Related Files

```
routes/
  └── web.php (Routes untuk create, edit, update)

app/Http/Controllers/Student/
  └── ReportController.php (Validasi server)

resources/views/student/reports/
  ├── create.blade.php (Form buat + validasi)
  ├── edit.blade.php (Form edit + validasi)
  ├── index.blade.php (Daftar laporan)
  └── show.blade.php (Detail laporan)

app/Models/
  └── Report.php (Model + validasi rules)
```

---

**Last Updated**: January 6, 2026  
**Version**: 1.0
