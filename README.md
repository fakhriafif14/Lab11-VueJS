
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

### app.js

Mengatur seluruh logika Vue:

* Memuat data dari API menggunakan `axios.get`.
* Menampilkan data artikel di tabel.
* Formulir dinamis untuk tambah/ubah data.
* Fungsi hapus artikel menggunakan `axios.delete`.
* Real-time update tanpa reload halaman.

### style.css

Mengatur tata letak dan desain:

* Tabel artikel dengan tampilan rapi.
* Form input dalam modal yang responsif.
* Tombol interaktif untuk tambah, simpan, dan batal.

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
