# Font Files - Cotoris

Folder ini digunakan untuk menyimpan file font Cotoris dari Canva.

## Cara Mendapatkan Font Cotoris dari Canva:

### Opsi 1: Download dari Canva (Jika Tersedia)
1. Login ke Canva
2. Buka desain yang menggunakan font Cotoris
3. Cek apakah ada opsi untuk download font files

### Opsi 2: Menggunakan Tools Browser (Untuk Extract Font)
1. Buka Canva dan buat desain dengan font Cotoris
2. Gunakan Developer Tools browser (F12)
3. Cek Network tab untuk melihat apakah font files di-download
4. Download font files yang muncul

### Opsi 3: Alternatif - Gunakan Font Serupa
Jika font Cotoris tidak tersedia untuk download, Anda bisa menggunakan font serupa:
- Times New Roman
- Georgia
- Playfair Display
- Lora

## Format File Font yang Didukung:

- **.woff2** (format terbaik, ukuran terkecil) - Prioritas pertama
- **.woff** (fallback)
- **.ttf** (fallback)

## File Font yang Perlu Diunggah:

Silakan unggah file font berikut ke folder ini:
- `Cotoris-Regular.woff2` (atau .woff/.ttf untuk regular weight)
- `Cotoris-Bold.woff2` (atau .woff/.ttf untuk bold weight) - Opsional

**Catatan:** Setelah font files diunggah ke folder ini, font akan otomatis digunakan di seluruh website. CSS sudah dikonfigurasi untuk menggunakan font Cotoris.

## Struktur Folder Setelah Upload:

```
public/fonts/
├── Cotoris-Regular.woff2 (atau format lainnya)
├── Cotoris-Regular.woff (opsional)
├── Cotoris-Bold.woff2 (opsional)
└── README.md
```

## Troubleshooting:

Jika font tidak muncul:
1. Pastikan file font sudah diunggah ke folder ini
2. Pastikan nama file sesuai: `Cotoris-Regular.woff2`, `Cotoris-Regular.woff`, atau `Cotoris-Regular.ttf`
3. Clear cache browser (Ctrl+F5 atau Cmd+Shift+R)
4. Rebuild CSS dengan menjalankan `npm run build` atau `npm run dev`

