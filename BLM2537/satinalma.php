<?php
$mesaj = '';
$mesajGoster = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $host = 'localhost'; // veritabaninin erisim bilgileri
    $dbname = 'kredikarti';
    $username = 'root';
    $password = ''; // phpmyadmin uzerinde gozuken database adi

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Formdan gelen veriler
        $isim = $_POST['isim']; // İsim almak
        $kartNumarasi = $_POST['KN']; // Kart numarası
        $SKT = $_POST['SKT']; // Son kullanma tarihi
        $CVV = $_POST['CVV']; // CVV Kodu

        // Veritabanında isim ile kullanıcıyı bulma
        $sql = "SELECT * FROM users WHERE isim = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$isim]);
        $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($kullanici) {
            // Kart numarasını, SKT'yi ve CVV'yi karşılaştırma
            if ($kartNumarasi === $kullanici['KN'] && $SKT === $kullanici['SKT'] && $CVV === $kullanici['CVV']) {
                $mesaj = "Kart bilgileri doğrulandı!";
                $mesajGoster = true;
                // Giriş başarılı
                header("Location: indexlogined.html"); // Giriş sonrası yönlendirilecek sayfa
                exit();
            } else {
                $mesaj = "Kart bilgileri hatalı!";
                $mesajGoster = true;
            }
        } else {
            $mesaj = "Kullanıcı bulunamadı!";
            $mesajGoster = true;
        }
    } catch(PDOException $e) {
        $mesaj = "Veritabanı hatası: " . $e->getMessage();
        $mesajGoster = true;
    }
}?>


<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="Üniversite'ye Hazırlık Kursları" />
    <meta name="description" content="Kaliteli eğitim, kaliteli çocukların eğitimidir" />
    <title>BADERS ÖĞRENCİ BASVURU FORMU</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f0f4f7;
        color: #333;
      }

      h1 {
        text-align: center;
        font-size: 2.5rem;
        color: #fff;
        margin-top: 30px;
      }

      .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      .form-container {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 30px;
        border-radius: 10px;
        width: 400px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        color: #fff;
      }

      .form-container input,
      .form-container select {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        background-color: #fff;
        color: #333;
        font-size: 1rem;
        transition: all 0.3s;
      }

      .form-container input:focus,
      .form-container select:focus {
        outline: none;
        border-color: #4CAF50;
      }

      label {
        font-size: 1.1rem;
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
      }

      button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s;
      }

      button:hover {
        background-color: #45a049;
      }

      .icon {
        margin-right: 10px;
      }

      .price {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 10px;
        text-align: center;
        color: #ffeb3b;
      }
      
    </style>

    <?php if ($mesajGoster): ?>
      <div style="background-color: #ffcccb; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
        <?php echo htmlspecialchars($mesaj); ?>
      </div>
    <?php endif; ?>

  </head>
  <body>
    <img
      src="images/student.jpg"
      alt=""
      style="position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: -1; opacity: 0.6;"
    />
    <div class="container">
      <div class="form-container">
        <h1>BADERS EĞİTİM SATIŞ</h1>
        <form id="form" method="post">
        <div>
            <label for="isim">Kart Sahibi :</label>
            <input type="text" name="isim" id="isim" placeholder="Baran Demir" required />
          </div>
          <div>
            <label for="kart-numarasi">Kart Numarası :</label>
            <input type="text" name="KN" id="KN" placeholder="1111 2222 3333 4444" required />
          </div>
          <div>
            <label for="son-kullanma">Son Kullanma Tarihi :</label>
            <input type="text" name="SKT" id="SKT" placeholder="MM/YY" required />
          </div>
          <div>
            <label for="cvv">CVV Kodu :</label>
            <input type="text" name="CVV" id="CVV" placeholder="000" required />
          </div>

          
          <div>
            <label for="paket">Paket İçeriği : (YILLIK ÖDEME)</label>
            <select id="paket" name="paket" onchange="updatePrice()">
              <option value="tyt">TYT</option>
              <option value="ayt">AYT</option>
              <option value="tyt-ayt">TYT-AYT</option>
              <option value="ales">ALES</option>
              <option value="kpss">KPSS</option>
              <option value="all">HEPSİ</option>
            </select>
          </div>

          <div class="price" id="price">Fiyat = 1500 TL </div>

          <button type="submit">
            <i class="fa-solid fa-money-bill"></i>
            Satın Al
            <i class="fa-solid fa-money-bill"></i>
          </button>
        </form>
      </div>
    </div>

    <script>
      function updatePrice() {
        const sinavTuru = document.getElementById("paket").value;
        const priceElement = document.getElementById("price");

        let price;

        switch (sinavTuru) {
          case "tyt":
            price = 1500;
            break;
          case "ayt":
            price = 2000;
            break;
          case "tyt-ayt":
            price = 3000;
            break;
          case "ales":
            price = 2000;
            break;
          case "kpss":
            price = 2500;
            break;
            case "all":
            price = 5000;
            break;
          default:
            price = 1500;
            break;
        }

        priceElement.textContent = `Fiyat: ${price} TL`;
      }
    </script>
  </body>
</html>
