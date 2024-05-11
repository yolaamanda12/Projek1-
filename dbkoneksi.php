<?php
// Konfigurasi database
$host = 'localhost'; // Ganti sesuai dengan host Anda
$dbname = 'database1'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan nama pengguna database Anda
$pass = ''; // Ganti dengan kata sandi database Anda

$dsn = "mysql:host=$host;dbname=$dbname";

// Buat koneksi Database
$dbh = new PDO($dsn, $user, $pass);

$conn = mysqli_connect("localhost", "root", "", "database1");


// Function registrasi dan login

function registrasi ($data) {

    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek username sudah tersedia belum
    $result = mysqli_query($conn,"SELECT username from users where username= '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('Username sudah terdaftar');
        </script>";
        return false;
    }
    // Cek kofirmasi password
    if ($password !== $password2) {
        echo "<script>
            alert('Konfirmasi password tidak sesuai');
        </script>";
        return false;
    }
    
    //  enkripsikan password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // Menambahkan user ke dalam database
    mysqli_query($conn, "INSERT INTO users VALUES(' ', '$username', '$password')");

    return mysqli_affected_rows($conn);

}

?>
