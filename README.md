
<em><h2>Sistem Manajemen Magang</h2></em>
	<h2>:raised_hand_with_fingers_splayed:  Hai, Perkenalkan!</h2>  
 Saya Alva, dan di sini saya akan membagikan penjelasan mengenai proses menjadi seorang Backend Developer dalam proyek Sistem Manajemen Magang. Penjelasan ini akan mencakup langkah-langkah mulai dari:
 
  1. ✅ Instalasi tools yang diperlukan

2.  ⚙️ Pembuatan dan konfigurasi backend

3.  🔄 Pengelolaan database

4.  🧪 Pengujian API menggunakan Postman

Baiklah kita akan mulai saja untuk proses nya 😄

<h2>1. Pertama</h2>
Langkah Pertama yang Harus Kalian Lakukan adalah Menginstall composer, composer berfungsi untuk Install dan manage library/package PHP lalu. Install composer bisa kalian unduh melewati website dengan link ( https://getcomposer.org/download/) setelah itu kalian ke terminal Visual Code lalu jalankan

``` 
composer -V
```
jika nanti outputnya keluar versi Composer maka untuk composer sudah selesai terinstall

<h2>2. Kedua</h2>
Langkah Kedua kita akan menginstall Framework CodeIgniter Versi 4, untuk penginstalan bisa dilakukan di Website dengan link (https://codeigniter.com/download), jika sudah di download jangan lupa di ekstrak lalu masukan file CI4 tersebut ke folder (laragon -> www).


<h2>3. Ketiga</h2>
Langkah Ke 3 ialah menyalakan website backend kamu yang telah di buat untuk di coba testing. Anda bisa jalankan kode ini di terminal VS Code ;

```
php spark serve
```

<h2>4. Keempat</h2>
Langkah Ke Empat ialah membuat sebuah database untuk mencoba mengkoneksikan sistem yang akan dibuat, disini saya menggunakan phpmyadmin jadi langsung buka saja laragon lalu klik start dan klik database, disitu saya membuat sebuah database baru dengan nama sistem_manajemen_magang setelah itu membuat sebuah tabel seperti Mahasiswa, Pembibing, Perusahaan, Magang, serta User juga.

<h2>5. Kelima</h2>
Langkah Kelima kalian langsung saja menambahkan serta memodifikasikan framework yang akan kalian jalankan,
pertama saya fokus ke file database.php yang berada di folder config ;

```
'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => '',
        'database'     => 'sistem_manajemen_magang',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
```
disini saya merubah hotname menjadi localhost, username menjadi root (sesuaikan apa yang kamu isi saat masuk ke database phpmyadmin) dan database menjadi sistem_manajemen_magang yang sebelumnya telah dibuat.

- Kedua saya beralih ke folders Models di situ saya membuat sebuah file sesuai yang ada ditabel database dengan guna untuk menjebatani antara database dan controller agar bisa bekerja sistemnya.

- Ketiga kita membuat sebuah controller yang mengatur sebuah logika mulai dari fitur CRUD dan lainya

- Ke empat kita membuat sebuah routes. routes adalah traffic controller untuk semua request yang masuk ke aplikasi kamu yang berada di folder config dan file routes.php. 
contoh sebuah routes yang telah saya buat ; 
```
$routes->group('mahasiswa', function($routes) {
    $routes->get('/', 'MahasiswaController::index');
    $routes->get('(:segment)', 'MahasiswaController::show/$1');
    $routes->post('/', 'MahasiswaController::store');
    $routes->put('update/(:segment)', 'MahasiswaController::update/$1');
    $routes->delete('delete/(:segment)', 'MahasiswaController::delete/$1');
});
```
<h2>6. Keenam</h2>
Langkah Ke enam kita akan menginstall software aplikasi berupa postman yang nantinya berguna untuk Test API endpoints tanpa perlu frontend,
Cek apakah API kamu bekerja dengan benar dan Debug API response. untuk menginstal aplikasi tersebut bisa melalui link berikut (https://www.postman.com/) 

<h2>7. Ketujuh</h2>
langkah selanjutnya adalah uji coba menggunakan postman yang telah kita install 




