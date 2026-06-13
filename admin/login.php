<?php
session_start();

if(isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - Kedai Maung Boba</title>

<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Manrope',sans-serif;
}

body{
min-height:100vh;
background:#f8f6f3;
display:flex;
overflow:hidden;
}

/* =========================
   PANEL KIRI
========================= */

.login-left{
width:55%;
position:relative;

background:url('../assets/img/logo.png');
background-size:cover;
background-position:center;
background-repeat:no-repeat;
}

.overlay{
position:absolute;
inset:0;

background:
linear-gradient(
90deg,
rgba(0,0,0,.15),
rgba(0,0,0,.05)
);
}

/* =========================
   PANEL KANAN
========================= */

.login-right{
width:45%;
display:flex;
justify-content:center;
align-items:center;
padding:40px;
background:#f8f6f3;
}

.login-card{
width:100%;
max-width:500px;

background:white;

padding:40px;

border-radius:28px;

box-shadow:
0 20px 50px rgba(0,0,0,.08);
}

.login-card h2{
font-size:32px;
font-weight:700;
color:#222;
margin-bottom:10px;
}

.subtitle{
color:#777;
line-height:1.8;
margin-bottom:30px;
}

/* =========================
   FORM
========================= */

.form-group{
margin-bottom:20px;
}

.form-group label{
display:block;
margin-bottom:8px;
font-size:14px;
font-weight:700;
color:#333;
}

.input-box{
position:relative;
}

.left-icon{
position:absolute;
left:18px;
top:50%;
transform:translateY(-50%);
color:#999;
}

.toggle-pass{
position:absolute;
right:18px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
color:#999;
}

.input-box input{
width:100%;
height:58px;

background:#fafafa;

border:2px solid #ececec;

border-radius:16px;

padding-left:50px;
padding-right:50px;

font-size:15px;

outline:none;
transition:.3s;
}

.input-box input:focus{
border-color:#a66b42;

box-shadow:
0 0 0 4px rgba(166,107,66,.12);
}

.login-options{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
font-size:14px;
}

.login-options label{
display:flex;
align-items:center;
gap:8px;
cursor:pointer;
}

.login-options a{
text-decoration:none;
font-weight:700;
color:#a66b42;
}

.login-options a:hover{
text-decoration:underline;
}

/* =========================
   BUTTON
========================= */

.btn-login{
width:100%;
height:58px;

border:none;
border-radius:16px;

background:
linear-gradient(
135deg,
#c58b54,
#8b5a34
);

color:white;

font-size:16px;
font-weight:700;

cursor:pointer;
transition:.3s;
}

.btn-login:hover{
transform:translateY(-2px);

box-shadow:
0 15px 35px rgba(139,90,52,.35);
}

/* =========================
   ERROR
========================= */

.error{
background:#ffeaea;
color:#d63031;
padding:14px;
border-radius:12px;
margin-bottom:20px;
}

.footer-login{
text-align:center;
margin-top:20px;
font-size:13px;
color:#999;
}

/* =========================
   TABLET
========================= */

@media(max-width:992px){

.login-left{
display:none;
}

.login-right{
width:100%;
padding:25px;
}

.login-card{
max-width:500px;
}

}

/* =========================
   MOBILE
========================= */

@media(max-width:576px){

.login-right{
padding:15px;
}

.login-card{
padding:25px;
border-radius:20px;
}

.login-card h2{
font-size:28px;
}

.subtitle{
font-size:14px;
}

.login-options{
flex-wrap:wrap;
gap:10px;
}

}

</style>

</head>

<body>

<div class="login-left">

<div class="overlay"></div>

</div>

<div class="login-right">

<div class="login-card">

<h2>Login</h2>

<p class="subtitle">
Masukkan username dan password untuk melanjutkan.
</p>

<?php if(isset($_GET['error'])){ ?>

<div class="error">
Username atau Password Salah
</div>

<?php } ?>

<form action="proses_login.php" method="POST">

<div class="form-group">

<label>Username</label>

<div class="input-box">

<i class="bi bi-person left-icon"></i>

<input
type="text"
name="username"
placeholder="Masukkan username"
required>

</div>

</div>

<div class="form-group">

<label>Password</label>

<div class="input-box">

<i class="bi bi-lock left-icon"></i>

<input
type="password"
id="password"
name="password"
placeholder="Masukkan password"
required>

<i
class="bi bi-eye toggle-pass"
onclick="togglePassword()"></i>

</div>

</div>

<div class="login-options">

<label>
<input type="checkbox">
Ingat Saya
</label>

<a href="#">
Lupa Password?
</a>

</div>

<button
type="submit"
class="btn-login">

Masuk ke Dashboard

</button>

<div class="footer-login">
© 2025 Kedai Maung Boba
</div>

</form>

</div>

</div>

<script>

function togglePassword(){

const pass =
document.getElementById('password');

if(pass.type === 'password'){
pass.type = 'text';
}else{
pass.type = 'password';
}

}

</script>

</body>
</html>

