<?php
// home.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CNO NutriMap | Home</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      background: white;
      box-shadow: 0px 1px 5px rgba(0,0,0,0.1);
    }
    .logo {
      font-weight: bold;
      font-size: 1.2rem;
    }
    .logo span {
      color: #00B2B2;
    }
    .nav {
      display: flex;
      gap: 25px;
      align-items: center;
    }
    .nav a {
      text-decoration: none;
      color: black;
      font-size: 0.9rem;
      transition: color 0.3s ease;
    }
    .nav a.active,
    .nav a:hover {
      color: #00B2B2;
    }
    .login-btn {
      border: 1px solid black;
      background: white;
      padding: 5px 12px;
      cursor: pointer;
      border-radius: 4px;
      transition: background 0.3s ease;
    }
    .login-btn:hover {
      background: #f2f2f2;
    }

    /* Main */
    main {
      position: relative;
      background-image: url('img/bg_img.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 120px 50px;
    }
    main .overlay {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.45);
    }
    main .content {
      position: relative;
      z-index: 1;
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1100px;
      width: 100%;
    }
    .left {
      flex: 1;
    }
    .left h1 {
      font-size: 50px;
      font-weight: bold;
      line-height: 1;
    }
    .left h1 span {
      color: #00B2B2;
    }
    .left p {
      margin-top: 10px;
      font-size: 18px;
    }
    .left a.button {
      margin-top: 20px;
      display: inline-block;
      background: #00B2B2;
      color: white;
      font-weight: bold;
      padding: 12px 24px;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    .left a.button:hover {
      background: #009090;
    }
    .right-panel {
      flex: 1;
      text-align: center;
    }
    .right-panel img {
      max-width: 500px;
      height: auto;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <div class="logo"><span>CNO</span> NutriMap</div>
    <div class="nav">
      <a href="landing_page/home.php" class="active">HOME</a>
      <a href="landing_page/map.php">NUTRITIONAL MAP</a>
      <a href="#">GET TO KNOW US</a>
      <a href="#">CONTACT US</a>
      <a href="login.php"><button class="login-btn">LOGIN</button></a>
    </div>
  </div>

  <!-- Main -->
  <main>
    <div class="overlay"></div>
    <div class="content">
      <div class="left">
        <h1>Welcome to <br><span>City Nutrition Office</span></h1>
        <p>El Salvador, Misamis Oriental</p>
        <a href="orgchart.php" class="button">Know More About Us!</a>
      </div>
      <div class="right-panel">
        <img src="img/nutritional.png" alt="Nutrition Illustration">
      </div>
    </div>
  </main>

</body>
</html>
