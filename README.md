SISTEM MANAJEMEN MAGANG

📦 1. Instalasi Composer
CodeIgniter 4 membutuhkan Composer untuk mengelola dependensi.

Langkah-langkah:
- Download Composer:
https://getcomposer.org/download/
- Cek versi untuk memastikan Composer sudah terinstall:
composer -V

🛠️ 2. Instalasi CodeIgniter 4

Setelah Composer siap, install CodeIgniter 4 dengan perintah:

composer create-project codeigniter4/appstarter nama-proyek


⚙️ 3. Menjalankan Server CodeIgniter
Jalankan server development CodeIgniter:

php spark serve

Output-nya akan muncul seperti:

CodeIgniter development server started on http://localhost:8080


🛣️ 4. Tambahkan Route API

Edit file app/Config/Routes.php:


contoh ;


// Routes untuk Mahasiswa API


$routes->group('mahasiswa', function($routes) {

    $routes->get('/', 'MahasiswaController::index');
    
    $routes->get('(:segment)', 'MahasiswaController::show/$1');
    
    $routes->post('/', 'MahasiswaController::store');
    
    $routes->put('update/(:segment)', 'MahasiswaController::update/$1');
    
    $routes->delete('delete/(:segment)', 'MahasiswaController::delete/$1');
    
    
🧪 5. Testing API (Optional)

Gunakan Postman, Insomnia, atau cURL untuk menguji endpoint:

GET: http://localhost:8080/mahasiswa

POST: http://localhost:8080/mahasiswa

PUT: http://localhost:8080/mahasiswa/update/260202039


DELETE: http://localhost:8080/mahasiswa/delete/230202039

