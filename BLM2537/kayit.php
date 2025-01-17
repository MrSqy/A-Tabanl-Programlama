<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $dbname = 'kullanici_kayit';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $isim = $_POST['isim'];
        $email = $_POST['email'];
        $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (isim, email, sifre) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$isim, $email, $sifre]);

        echo "<div style='color:green'>Kayıt başarılı!</div>";
        
    } catch(PDOException $e) {
        echo "<div style='color:red'>Hata oluştu: " . $e->getMessage() . "</div>";
    }
}
?>



<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="Üniversite'ye Hazırlık Kursları" />
    <meta
      name="description"
      content="Kaliteli eğitim, kaliteli çocukların eğitimidir"
    />
    <title>BADERS KAYIT</title>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <style>
        body{
            margin:0;
            color: white;
        }
        img{
            position: absolute;
            width: 100%;
            height: 100%;
            margin: auto;
            z-index: -1;
            opacity: 80%;
            
        }
        h1{
            text-align: center;
            top: 0px;
        }

        #form{
            text-align: center;
            margin-top: 50px;
        }
        div{
            position: absolute;
            left: 33%;
            margin: 120px auto;
            width: 500px;
            height: 600px;
            border: 10px solid rgb(255,255,255);
            z-index: 10;
            border-radius: 4%;
            background-color: rgba(0,0,0, 0.800);
        }
        p#branslar{
            text-align: left;
            margin-left: 140px;
        }
        label{
            font-weight: bold;
            font-size: large; 
        }
        span#cins{
            margin-right: 40px;
            font-weight: normal;
        }
        #sinif{
            margin-right: 80px;
           
        }
        input#e-posta{
            position: relative;
            left: 6px;
        }
        input#parola{
            position: relative;
            left: 10px;
        }
        #c2{
            position: relative;
            left: 16.5px;
        }
        #c3{
            position: relative;
            left: 25.5px;
        }
        #c4{
            position: relative;
            left: 35.5px;
        }
        span{
            font-weight: bold;
            font-size: large;
        }
        a{
        color: black;
        text-decoration: none;
        border: 3px solid black;
        border-radius: 30%;
        background-color: white;
        position: relative;
        top: 15px;
        left: 180px;
        transition: 0.8s;
        cursor: grab;
        display:block;
        width: 140px;
        
      }
      a:hover{
        border: 3px solid white;
        background-color: black;
        color: aqua;
        
      }
      button{
        color: black;
        text-decoration: none;
        border: 3px solid black;
        border-radius: 30%;
        background-color: white;
        position: relative;
        top: 15px;
        left: 180px;
        transition: 0.8s;
        cursor: grab;
        display:block;
        width: 140px;
        
      }
      button:hover{
        border: 3px solid white;
        background-color: black;
        color: aqua;
        
      }
      #eposta{
        position: relative;
            left: 7.5px;
      }
      #num{
        position: relative;
            left: 9.5px;
      }
      
    </style>

  </head>
  <body>
    <img src="images/student.jpg" alt="">
    <div>
        
    <h1>BADERS KAYIT FORMU</h1>

    <form action="kayit.php" id="form" method="post">
    <p>
        <label for="isim">Ad-Soyad :</label> <input type="text" name="isim" id="isim" placeholder="Baran Demir" required>
    </p>
            
    <p> 
        <label for="email">E-Posta :</label> <input type="email" name="email" id="email" placeholder="baranbeey@baranmail.com" required> 
    </p>
    <p> 
    <label for="sifre">Parola :</label> <input type="password" name="sifre" id="sifre" placeholder="+90 555 123 4567" required>
    </p>
    
    <button id="submit" name="submit"> 
        <i class="fa-brands fa-telegram"></i>
        Kayıt Ol
        <i class="fa-brands fa-telegram"></i>
    </button>

    <a id="submit" name="submit"> 
        <i class="fa-brands fa-telegram"></i>
        Giriş Yapma Ekranına Dön
        <i class="fa-brands fa-telegram"></i>
    </a>
</p></div>
</form>
  </body>
</html>


