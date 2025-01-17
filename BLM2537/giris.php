<?php
$mesaj = "";
$mesajGoster = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $dbname = 'kullanici_kayit';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST['E-Posta'];
        $sifre = $_POST['parola'];

        
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
            
            header("Location: indexlogined.html"); 
            exit();
        } else {
            $mesaj = "E-posta veya şifre hatalı!";
            $mesajGoster = true;
        }
    } catch(PDOException $e) {
        $mesaj = "Veritabanı hatası: " . $e->getMessage();
        $mesajGoster = true;
    }
}
?>


<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="Üniversite'ye Hazırlık Kursları" />
    <meta name="description" content="Kaliteli eğitim, kaliteli çocukların eğitimidir" />
    <title>BADERS GİRİŞ</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <style>
    body { 
        margin: 0;
        color: white; 
    }
      img { 
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 80%;
    }
      h1 { 
        text-align: center;
        font-size: large;
        font-weight: bold;
    }
      #form { 
        text-align: center; 
        margin-top:50px; 
      }
      div#error { 
        position: absolute;
        left: 33%; 
        margin: 120px auto;
        width: 500px;
        height: 500px;
        border: 10px solid rgb(255, 255, 255);
        z-index: 10; 
        border-radius: 4%;
        background-color: rgba(0, 0, 0, 0.800);
    }
      #uyaribalonu {
        position: fixed;
        top: 20px;
        right: 41%;
        background-color: rgb(255, 255, 255);
        color: #333; 
        padding: 10px 20px; 
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
      #uyaribalonu.gorunur {
        opacity: 1;
        transform: translateY(0);
    }
      button, a {
        color: black;
        border: 1px solid black;
        border-radius: 16%;
        background-color: gray;
        transition: 0.8s;
        cursor:grab;
        padding: 2px 3px;
        text-decoration: none;
    }
      button:hover, a:hover {
        border: 1px solid cyan;
        border-radius: 16%;
        background-color: black;
        transition: 0.8s;
        color: white;
    }
    </style>
  </head>

  <body>
    <img src="images/maintop.jpg" alt="">
    <div id="error">
      <h1>BADERS GİRİŞ FORMU</h1>
      <div id="uyaribalonu">Lütfen Bilgilerinizi Kontrol Ediniz...</div>
      <form id="form" method="post">
        <p> 
          <label for="eposta"><h1>E-Posta :
          <input type="email" name="E-Posta" id="E-Posta" placeholder="baranbeey@baranmail.com" required>
          </h1></label>
        </p>
        <p> 
          <label for="parola"><h1>Parola :
          <input type="password" name="parola" id="parola" placeholder="*********" required>
          </h1></label>
        </p>
        <button type="submit" id="submit" name="submit"> 
          <i class="fa-brands fa-telegram"></i> Giriş Yap <i class="fa-brands fa-telegram"></i>
        </button>
        <p>
          <a id="submit" name="submit" href="basvuruformuogrenci.php"> 
            <i class="fa-brands fa-telegram"></i> Öğrenci Kayıt Olma Formu <i class="fa-brands fa-telegram"></i>
          </a>
        </p>
        <p>
          <a id="submit" name="submit" href="basvuruformuegitmen.php"> 
            <i class="fa-brands fa-telegram"></i> Eğitmen Kayıt Olma Formu <i class="fa-brands fa-telegram"></i>
          </a>
        </p>
      </form>
    </div>

    <script>
    <?php if($mesajGoster): ?>
    document.addEventListener('DOMContentLoaded', function() {
        var uyariBalonu = document.getElementById('uyaribalonu');
        uyariBalonu.textContent = "<?php echo $mesaj; ?>";
        uyariBalonu.classList.add('gorunur');
        
        setTimeout(function() {
            uyariBalonu.classList.remove('gorunur');
        }, 3000); 
    });
    <?php endif; ?>
    </script>
  </body>
</html>
