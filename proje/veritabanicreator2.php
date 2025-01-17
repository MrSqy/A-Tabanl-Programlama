<?php
$host = 'localhost'; // veritabaninin erisim bilgileri
$username = 'root';
$password = '';
$dbname = 'kredikarti'; // phpmyadmin uzerinde gozuken database adi

try {
    // terimler $conn anlam olarak baglanti kurarken kullanilir. $exec ise execute yani işlemenin kisaltmasidir.
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"); // veritabani olusturur, varsa var olani kullanir
    echo "Veritabanı oluşturuldu veya zaten mevcut.<br>"; // dosya tarayici uzerinde acilinca ekrana yazilacak metin

    $conn->exec("USE $dbname"); // kullanilacak database'i secer. USE $dbname ifadesi yukarida olusturulmus olan kredikarti database'ini isaret eder

    // veri tabanindaki bilgileri ve onlarin bellekte depolanacagi veri tipi/uzunlugu belirlenir
    $sqlCreateTable = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        isim VARCHAR(100) NOT NULL,
        KN VARCHAR(100) NOT NULL UNIQUE,
        SKT VARCHAR(100) NOT NULL,
        CVV VARCHAR(255) NOT NULL,
        kayit_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"; // kayit_tarihi degiskeni kayit olundugu andaki (current) tarihi veritabanina kaydeder
    $conn->exec($sqlCreateTable);
    echo "Tablo oluşturuldu veya zaten mevcut.<br>";
} catch (PDOException $e) { // exception handle (hata yonetimi) blogunun diger parcasi. try kisminda bir hata meydana gelirse bu blok calisir ve ekrana hata mesaji yazdirilir
    echo "Hata: " . $e->getMessage();
}
?>
