 
 <style>
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

 </style>
 <div class="header">
    <div class="logo"><span>CNO</span> NutriMap</div>
    <div class="nav">
      <a href="../index.php">HOME</a>
      <a href="landing_page/map.php">NUTRITIONAL MAP</a>
      <a href="#">GET TO KNOW US</a>
      <a href="#">CONTACT US</a>
      <a href="login.php"><button class="login-btn">LOGIN</button></a>
    </div>
  </div>