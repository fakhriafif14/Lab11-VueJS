
---

# **📝 Identitas Praktikum**

| **Nama**         | Fakhri afif muhaimin |
| ---------------- | -------------------  |
| **NIM**          | 312310632            |
| **Kelas**        | TI.23.A6             |
| **Mata Kuliah**  | Pemrograman Web 2    |
| **Link YouTube** | *(Belum tersedia)*   |

---

# Lab11Web & VueJS

**Lab11Web** adalah sebuah aplikasi web berbasis **CodeIgniter 4** yang dirancang untuk mengelola data artikel secara menyeluruh, mencakup fitur CRUD (Create, Read, Update, Delete), pencarian data, paginasi, dan upload gambar. Sistem ini juga dilengkapi dengan autentikasi berupa login, logout, pengelolaan sesi (session), serta filter akses pengguna.

Pada sisi **frontend**, digunakan konsep **Single Page Application (SPA)** sederhana dengan memanfaatkan **Vue.js**, di mana file `index.html` menjadi struktur utama tampilan dan modal form, sedangkan file `app.js` mengatur proses pengambilan data (menggunakan `axios.get`), penambahan (`axios.post`), pengeditan (`axios.put`), serta penghapusan data (`axios.delete`) artikel secara dinamis. Styling dilakukan melalui file `style.css` yang mendukung tampilan responsif serta desain modal yang menarik.

---

## ${\color{lightblue}\textbf{Teknologi yang Digunakan}}$

![Code-Igniter](https://img.shields.io/badge/CodeIgniter-%23EF4223.svg?style=for-the-badge\&logo=codeIgniter\&logoColor=white) ![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge\&logo=vuedotjs\&logoColor=%234FC08D) ![Postman](https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge\&logo=postman\&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge\&logo=mysql\&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge\&logo=php\&logoColor=white) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge\&logo=html5\&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge\&logo=css3\&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge\&logo=javascript\&logoColor=%23F7DF1E)

---

**Postman** digunakan untuk melakukan pengujian sekaligus dokumentasi seluruh endpoint RESTful pada backend **CodeIgniter**, memastikan setiap metode seperti GET, POST, PUT, dan DELETE berfungsi dengan baik dan memberikan response berformat JSON serta kode status HTTP yang sesuai.

Di sisi lain, **Vue.js** berperan sebagai antarmuka pengguna yang interaktif, dengan fitur:

* Menampilkan daftar artikel menggunakan `v-for` dan binding data dua arah dengan `v-model`.
* Form tambah/edit artikel muncul dalam modal dengan bantuan `v-if`.
* Seluruh perubahan data ditampilkan secara **real-time**, tanpa perlu me-refresh halaman.

## Konsep Kerja REST API: REST Server & REST Client

**REST (Representational State Transfer)** adalah pendekatan arsitektural dalam pembuatan API (Application Programming Interface) yang memungkinkan komunikasi standar antar aplikasi. Dalam model ini:

* **Server** berperan sebagai penyedia resource atau data.
* **Client** mengirimkan request ke server menggunakan HTTP method seperti GET, POST, PUT, dan DELETE, melalui URI (Uniform Resource Identifier).
* Server kemudian memberikan response dalam format standar, biasanya JSON.

Contohnya, backend dapat dibangun menggunakan PHP & REST API, sedangkan frontend dikelola menggunakan **Vue.js**, sehingga keduanya dapat berinteraksi secara modular dan efisien.

---

## Persiapan Praktikum

Langkah awal adalah mempersiapkan aplikasi REST Client seperti **Postman**, yang digunakan untuk mengetes setiap endpoint REST API. Anda bisa mengunduh Postman melalui tautan resmi berikut: [Download Postman](https://www.postman.com/downloads/).

---

## Implementasi Backend dengan REST API

### Model Artikel

Model **ArtikelModel** telah dibuat pada modul sebelumnya dan akan digunakan kembali untuk kebutuhan API.

### Membuat REST Controller

Buat file controller `Post.php` di folder `app/Controllers` dengan kode berikut:
```php
<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;
    // all users
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
    // create
    public function create()
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi' => $this->request->getVar('isi'),
        ];
        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }
    // single user
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
    // update
    public function update($id = null)
    {
        $model = new ArtikelModel();
        $id = $this->request->getVar('id');
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi' => $this->request->getVar('isi'),
        ];
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data artikel berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }
    // delete
    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->delete($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}
```



Controller ini memiliki lima fungsi utama:

* `index()` : Menampilkan seluruh data artikel.
* `create()` : Menambahkan data baru.
* `show()` : Menampilkan detail artikel berdasarkan ID.
* `update()` : Memperbarui data artikel.
* `delete()` : Menghapus artikel.

---

### Routing REST API

Tambahkan kode berikut pada file `app/Config/Routes.php`:

```php
$routes->resource('post');
```

Gunakan perintah:

```bash
php spark routes
```

Untuk melihat daftar lengkap endpoint yang dihasilkan.

---

### Pengujian REST API dengan Postman

1. **Menampilkan Semua Artikel**

   * Method: GET
   * URL: `http://localhost:8080/post`

2. **Menampilkan Artikel Spesifik**

   * Method: GET
   * URL: `http://localhost:8080/post/{id}`

3. **Menambahkan Artikel**

   * Method: POST
   * URL: `http://localhost:8080/post`

4. **Mengubah Artikel**

   * Method: PUT
   * URL: `http://localhost:8080/post/{id}`

5. **Menghapus Artikel**

   * Method: DELETE
   * URL: `http://localhost:8080/post/{id}`

---

## Praktikum Vue.js

**Vue.js** adalah framework JavaScript yang memudahkan pembuatan tampilan website interaktif berbasis komponen. Vue bersifat progresif, ringan, mudah dipelajari, dan berfokus pada layer presentasi. Untuk praktikum ini, kita menggunakan integrasi manual dengan CDN dan library tambahan **Axios** untuk komunikasi ke REST API.

### Library yang Digunakan

```html
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
```

---

## Struktur Folder

```
lab11_vuejs/
├── index.html
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
```

---

## Tampilan Data Artikel dengan Vue.js

### index.html
Berisi struktur utama halaman, tombol tambah data, modal form artikel, serta tabel daftar artikel.
#### File index.html
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frontend Artikel VueJS</title>
    <!-- CDN untuk VueJS 3 -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- CDN untuk Axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Link ke CSS kustom -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="app">
        <h1>Daftar Artikel</h1>

        <!-- Tombol Tambah Data -->
        <button id="btn-tambah" @click="tambah">Tambah Data</button>

        <!-- Modal Form Tambah dan Ubah Data -->
        <div class="modal" v-if="showForm">
            <div class="modal-content">
                <span class="close" @click="showForm = false">&times;</span>
                <form id="form-data" @submit.prevent="saveData">
                    <h3 id="form-title">{{ formTitle }}</h3>
                    <div>
                        <label for="judul" class="form-label">Judul Artikel</label> <!-- Label untuk Judul -->
                        <input type="text" name="judul" id="judul" v-model="formData.judul" placeholder="Judul" required>
                    </div>
                    <div>
                        <label for="isi" class="form-label">Isi Artikel</label> <!-- Label untuk Isi -->
                        <textarea name="isi" id="isi" rows="10" v-model="formData.isi" placeholder="Isi Artikel"></textarea>
                    </div>
                    <div>
                        <label for="status" class="form-label">Status</label> <!-- Label untuk Status -->
                        <select name="status" id="status" v-model="formData.status">
                            <option v-for="option in statusOptions" :value="option.value" :key="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                    <!-- Hidden input untuk ID artikel saat edit -->
                    <input type="hidden" id="id" v-model="formData.id">
                    <button type="submit" id="btnSimpan">Simpan</button>
                    <button type="button" @click="showForm = false">Batal</button>
                </form>
            </div>
        </div>

        <!-- Tabel untuk menampilkan data artikel -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop melalui array artikel -->
                <tr v-for="(row, index) in artikel" :key="row.id">
                    <td class="center-text">{{ row.id }}</td>
                    <td>{{ row.judul }}</td>
                    <td>{{ statusText(row.status) }}</td>
                    <td class="center-text">
                        <a href="#" @click.prevent="edit(row)">Edit</a>
                        <a href="#" @click.prevent="hapus(index, row.id)">Hapus</a>
                    </td>
                </tr>
                <tr v-if="artikel.length === 0">
                    <td colspan="4" class="center-text">Tidak ada artikel tersedia.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Link ke JavaScript aplikasi VueJS kita -->
    <script src="assets/js/app.js"></script>
</body>
</html>
```
### app.js

Mengatur seluruh logika Vue:
* Memuat data dari API menggunakan `axios.get`.
* Menampilkan data artikel di tabel.
* Formulir dinamis untuk tambah/ubah data.
* Fungsi hapus artikel menggunakan `axios.delete`.
* Real-time update tanpa reload halaman.

#### File app.js
```javascript
const { createApp } = Vue;

// Tentukan lokasi API REST End Point Anda
// Contoh: 'http://localhost:8080/post' jika Anda mengaksesnya langsung
// atau 'http://localhost/labci4/public/post' jika public bukan root
const apiUrl = 'http://localhost/Lab11_ci/ci4/public/post'; // Sesuaikan ini dengan URL API Anda!

createApp({
    data() {
        return {
            artikel: [], // Array untuk menyimpan data artikel
            
            // Objek untuk data form (digunakan untuk tambah dan ubah)
            formData: {
                id: null,
                judul: '',
                isi: '',
                status: 0 // Default status (misal: 0 untuk Draft)
            },
            
            showForm: false, // Kontrol tampilan modal form
            formTitle: 'Tambah Data', // Judul modal form
            
            // Opsi untuk dropdown status
            statusOptions: [
                {text: 'Draft', value: 0}, // Sesuaikan value dengan kolom status di DB (0/1 atau 'Draft'/'published')
                {text: 'Publish', value: 1} // Jika status di DB Anda adalah string 'Draft'/'published', gunakan itu sebagai value
            ],
        };
    },
    
    // Dipanggil saat instance Vue selesai di-mount
    mounted() {
        this.loadData();
    },
    
    methods: {
        // Fungsi untuk memuat data artikel dari API
        loadData() {
            axios.get(apiUrl)
                .then(response => {
                    // Jika API mengembalikan { artikel: [...] }, akses response.data.artikel
                    // Jika API hanya mengembalikan [...], akses response.data
                    this.artikel = response.data.artikel || response.data; 
                    console.log("Data artikel dimuat:", this.artikel);
                })
                .catch(error => {
                    console.error("Error memuat data:", error);
                    alert("Gagal memuat data artikel. Cek konsol untuk detail.");
                });
        },
        
        // Fungsi untuk mengubah tampilan status (dari angka/boolean ke teks)
        statusText(status) {
            // Sesuaikan logika ini dengan bagaimana status disimpan di database Anda
            // Jika di DB adalah '0' atau '1' (string/number)
            if (status == 1 || status == '1' || status === 'published') {
                return 'Publish';
            } else if (status == 0 || status == '0' || status === 'Draft') {
                return 'Draft';
            }
            return ''; // Default jika status tidak dikenali
        },
        
        // Fungsi untuk menampilkan form tambah data
        tambah() {
            this.showForm = true;
            this.formTitle = 'Tambah Data';
            // Reset formData agar kosong untuk entri baru
            this.formData = {
                id: null,
                judul: '',
                isi: '',
                status: 0 // Default status untuk form tambah
            };
        },
        
        // Fungsi untuk menghapus artikel
        hapus(index, id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                axios.delete(apiUrl + '/' + id)
                    .then(response => {
                        alert(response.data.messages.success); // Tampilkan pesan sukses dari API
                        this.artikel.splice(index, 1); // Hapus item dari array di frontend
                        // Alternatif: this.loadData(); // Memuat ulang semua data dari server
                    })
                    .catch(error => {
                        console.error("Error menghapus data:", error.response || error);
                        alert("Gagal menghapus artikel: " + (error.response?.data?.messages?.error || error.message || "Terjadi kesalahan."));
                    });
            }
        },
        
        // Fungsi untuk mengisi form dengan data artikel yang akan diubah
        edit(data) {
            this.showForm = true;
            this.formTitle = 'Ubah Data';
            // Isi formData dengan data dari baris yang dipilih
            this.formData = {
                id: data.id,
                judul: data.judul,
                isi: data.isi,
                // Pastikan status sesuai dengan value di statusOptions (misal: 0 atau 1)
                status: data.status == 'published' ? 1 : (data.status == 'Draft' ? 0 : data.status)
            };
            console.log("Mengedit item:", this.formData);
        },
        
        // Fungsi untuk menyimpan atau mengubah data (dipanggil saat form disubmit)
        saveData() {
            // Jika formData.id ada, berarti ini adalah operasi ubah (PUT)
            if (this.formData.id) {
                axios.put(apiUrl + '/' + this.formData.id, this.formData)
                    .then(response => {
                        alert(response.data.messages.success || "Artikel berhasil diubah!");
                        this.loadData(); // Muat ulang data setelah perubahan
                        this.showForm = false; // Sembunyikan form
                        console.log('Item diperbarui:', response.data);
                    })
                    .catch(error => {
                        console.error("Error memperbarui item:", error.response || error);
                        alert("Gagal mengubah artikel: " + (error.response?.data?.messages?.error || error.message || "Terjadi kesalahan."));
                    });
            } else {
                // Jika formData.id null, berarti ini adalah operasi tambah (POST)
                axios.post(apiUrl, this.formData)
                    .then(response => {
                        alert(response.data.messages.success || "Artikel berhasil ditambahkan!");
                        this.loadData(); // Muat ulang data setelah penambahan
                        this.showForm = false; // Sembunyikan form
                        console.log('Item ditambahkan:', response.data);
                    })
                    .catch(error => {
                        console.error("Error menambahkan item:", error.response || error);
                        alert("Gagal menambahkan artikel: " + (error.response?.data?.messages?.error || error.message || "Terjadi kesalahan."));
                    });
            }
            
            // Reset form data setelah operasi selesai (atau di dalam then/catch block)
            this.formData = {
                id: null,
                judul: '',
                isi: '',
                status: 0
            };
        },
    },
}).mount('#app'); // Mount aplikasi Vue ke elemen dengan id "app"
```

<br>

### style.css

Mengatur tata letak dan desain:

* Tabel artikel dengan tampilan rapi.
* Form input dalam modal yang responsif.
* Tombol interaktif untuk tambah, simpan, dan batal.
#### File style.css
```css
/* Styling dasar untuk aplikasi VueJS */
#app {
    margin: 0 auto;
    width: 900px;
    padding: 20px; /* Tambahkan padding agar tidak terlalu mepet */
    font-family: sans-serif; /* Atur font-family */
}

h1 {
    text-align: center;
    color: #3152d6;
    margin-bottom: 20px;
}

table {
    min-width: 700px;
    width: 100%;
    border-collapse: collapse; /* Hilangkan jarak antar border cell */
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* Tambahkan sedikit bayangan */
    border-radius: 8px; /* Sudut membulat */
    overflow: hidden; /* Pastikan sudut membulat diterapkan */
}

th {
    padding: 12px 10px;
    background: #5778ff !important;
    color: #ffffff;
    text-align: left; /* Atur teks ke kiri */
}

tr td {
    border-bottom: 1px solid #eff1ff;
    padding: 10px;
}

tr:nth-child(odd) {
    background-color: #eff1ff;
}

td {
    padding: 10px;
}

.center-text {
    text-align: center;
}

td a {
    margin: 0 5px; /* Sesuaikan margin untuk link aksi */
    text-decoration: none; /* Hilangkan underline */
    color: #3152d6; /* Warna link */
}

td a:hover {
    text-decoration: underline; /* Munculkan underline saat hover */
}

/* Styling untuk form */
#form-data {
    width: 100%; /* Lebar form menyesuaikan modal-content */
}

form input,
form select,
form textarea {
    width: 100%;
    margin-bottom: 10px; /* Tambahkan margin-bottom */
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px; /* Sudut membulat */
}

form div {
    margin-bottom: 10px; /* Sesuaikan margin-bottom untuk setiap div form */
    position: relative;
}

form button {
    padding: 10px 20px;
    margin-top: 10px;
    margin-right: 10px;
    cursor: pointer;
    border: none;
    border-radius: 5px; /* Sudut membulat */
    font-weight: bold;
    transition: background-color 0.3s ease; /* Transisi halus */
}

#btn-tambah {
    margin-bottom: 15px;
    padding: 12px 25px;
    cursor: pointer;
    background-color: #28a745; /* Warna hijau untuk tambah */
    color: #ffffff;
    border: 1px solid #28a745;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

#btn-tambah:hover {
    background-color: #218838;
}

#btnSimpan {
    background-color: #3152d6;
    color: #ffffff;
    border: 1px solid #3152d6;
}

#btnSimpan:hover {
    background-color: #2640aa;
}

form button[type="button"] { /* Untuk tombol Batal */
    background-color: #6c757d;
    color: #ffffff;
}

form button[type="button"]:hover {
    background-color: #5a6268;
}

/* Styling Modal */
.modal {
    display: block; /* Default to block for v-if to toggle */
    position: fixed;
    z-index: 1000; /* Pastikan modal di atas konten lain */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.6); /* Lebih gelap sedikit dari modul */
    display: flex; /* Gunakan flexbox untuk centering */
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fefefe;
    padding: 30px; /* Tambah padding */
    border: 1px solid #888;
    width: 90%; /* Responsif */
    max-width: 600px; /* Batasi lebar maksimum */
    border-radius: 8px; /* Sudut membulat */
    box-shadow: 0 5px 15px rgba(0,0,0,0.3); /* Bayangan lebih kuat */
    position: relative; /* Untuk posisi tombol close */
}

.close {
    color: #aaa;
    float: right; /* Atur float untuk tombol close */
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    position: absolute; /* Posisi absolut di dalam modal-content */
    top: 10px;
    right: 15px;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

h3#form-title {
    text-align: center;
    color: #3152d6;
    margin-bottom: 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #app {
        width: 100%;
        padding: 10px;
    }
    table {
        font-size: 0.9em;
    }
    th, td {
        padding: 8px;
    }
}
```

---

## Dokumentasi Hasil Akhir

![vuejs](img/vuejs.gif)

Tampilan akhir **Lab11Web** menampilkan dashboard pengelolaan artikel berbasis **Vue.js** yang terintegrasi dengan REST API. Pengguna dapat:

* Melihat daftar artikel.
* Menambahkan artikel baru melalui form dalam modal.
* Mengedit data artikel yang ada.
* Menghapus artikel dengan konfirmasi.
* Semua interaksi dilakukan **tanpa reload halaman**, menerapkan konsep **SPA (Single Page Application)** sehingga sistem lebih efisien, cepat, dan responsif.

---

Kalau mau saya buatkan dalam format *markdown* siap tempel ke GitHub atau *PDF* untuk laporan, tinggal bilang saja!
