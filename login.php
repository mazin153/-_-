<?php
session_start();require_once "db.php";$message="";
if(isset($_GET["registered"]))$message="تم إنشاء الحساب بنجاح، يمكنك تسجيل الدخول الآن.";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $email=trim($_POST["email"]);$password=$_POST["password"];
 $stmt=$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");$stmt->execute([$email]);$user=$stmt->fetch();
 if($user&&password_verify($password,$user["password"])){
  if($user["status"]!=="active")$message="هذا الحساب غير مفعل.";
  else{session_regenerate_id(true);$_SESSION["user_id"]=$user["id"];$_SESSION["full_name"]=$user["full_name"];$_SESSION["role"]=$user["role"];
   header("Location: ".($user["role"]==="admin"?"admin.php":"profile.php"));exit;}
 }else $message="البريد الإلكتروني أو كلمة المرور غير صحيحة.";
}
?><!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>تسجيل الدخول</title><link rel="stylesheet" href="style.css"><style>.login-form{max-width:500px;margin:100px auto;background:#fff;padding:40px;border-radius:15px;box-shadow:0 10px 35px #00000012}.login-form h1{text-align:center;margin-bottom:30px}.login-form input{width:100%;padding:14px;margin-bottom:18px;border:1px solid #ddd;border-radius:8px}.login-form button{width:100%;border:0}.message{background:#e8f6f0;color:#176b55;padding:12px;border-radius:8px;margin-bottom:20px}</style></head><body><div class="login-form"><h1>تسجيل الدخول</h1><?php if($message):?><div class="message"><?=htmlspecialchars($message)?></div><?php endif;?><form method="POST"><input type="email" name="email" placeholder="البريد الإلكتروني" required><input type="password" name="password" placeholder="كلمة المرور" required><button class="btn btn-primary">تسجيل الدخول</button></form><p style="text-align:center;margin-top:20px">ليس لديك حساب؟ <a href="register.php" style="color:#15946e;font-weight:bold">إنشاء حساب</a></p></div></body></html>
