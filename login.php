<?php include("server/engine.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <!-- <title>Login</title> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Monitoring | AR Eastern</title>
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon-are-new-67x67.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <!-- <h2>Login Page</h2> -->
    <div class="login-dark">
    <?php if (!empty($_SESSION['flash_message'])): ?>
    <div id="toast" class="toast-message <?= strpos($_SESSION['flash_message'], '✅') !== false ? 'success' : 'error' ?>">
        <?= $_SESSION['flash_message'] ?>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) toast.style.display = 'none';
        }, 4000);
    </script>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

    <form method="post">
            <h2 class="login-title">Login Page</h2>
            
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input class="form-control" type="text" id="username" name="username" placeholder="Username" required></div>
            <div class="form-group"><input class="form-control" type="password" id="password" name="password" placeholder="Password" required></div>
            <div class="form-group"><button class="btn btn-primary btn-block login" type="submit" name="login_submit">Log In</button></div>
    </form>
    <!-- <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form> -->
    </div>
</body>
</html>

<style>
  .btn-group{
    float: right;
    top: 50px;
    right: 170px;
  }
  .btn-group .button {
  border: none;
  color: black;
  padding: 7px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  cursor: pointer;
  opacity: 0.45;
}

.btn-group .button:hover {
  background-color: #e7e7e7; color: black;
  
}
.login-title{
    text-align: center;
}
.login-dark {
  height:1000px;
  background:#475d62 url(./assets/img/banner-are.jpg);
  background-size:cover;
  background-position: center;
  position:relative;
}

.login-dark form {
  max-width:320px;
  width:90%;
  background-color:#1e2833;
  padding:40px;
  border-radius:4px;
  transform:translate(-50%, -50%);
  position:absolute;
  top:50%;
  left:50%;
  color:#fff;
  box-shadow:3px 3px 4px rgba(0,0,0,0.2);
}

.login-dark .illustration {
  text-align:center;
  padding:15px 0 20px;
  font-size:100px;
  color:#2980ef;
}

.login-dark form .form-control {
  background:none;
  border:none;
  border-bottom:1px solid #434a52;
  border-radius:0;
  box-shadow:none;
  outline:none;
  color:inherit;
}

.login-dark form .btn-primary {
  background:#214a80;
  border:none;
  border-radius:4px;
  padding:11px;
  box-shadow:none;
  margin-top:26px;
  text-shadow:none;
  outline:none;
}

.login-dark form .btn-primary:hover, .login-dark form .btn-primary:active {
  background:#214a80;
  outline:none;
}

.login-dark form .forgot {
  display:block;
  text-align:center;
  font-size:12px;
  color:#6f7a85;
  opacity:0.9;
  text-decoration:none;
}

.login-dark form .forgot:hover, .login-dark form .forgot:active {
  opacity:1;
  text-decoration:none;
}

.login-dark form .btn-primary:active {
  transform:translateY(1px);
}
.toast-message {
  position: fixed;
  top: 100px;
  right: 20px;
  padding: 12px 20px;
  border-radius: 6px;
  z-index: 9999;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  font-weight: bold;
  opacity: 0;
  font-family: sans-serif; 
  font-size: 16px; 
  animation: fadeInOut 4s forwards;
}
.toast-message.error {
  background-color: #f8d7da;
  color: #721c24;
}
@keyframes fadeInOut {
  0% { opacity: 0; transform: translateY(-10px); }
  10% { opacity: 1; transform: translateY(0); }
  90% { opacity: 1; transform: translateY(0); }
  100% { opacity: 0; transform: translateY(-10px); }
}
</style>