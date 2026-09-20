<?php
session_start(); require_once "db.php"; $message="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $full_name=trim($_POST["full_name"]);$phone=trim($_POST["phone"]);$email=trim($_POST["email"]);$password=$_POST["password"];
 $state=trim($_POST["state"]);$profession=trim($_POST["profession"]);$volunteer_field=trim($_POST["volunteer_field"]);
 if(!$full_name||!$phone||!$email||!$password)$message="يرجى تعبئة جميع البيانات المطلوبة.";
 elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))$message="البريد الإلكتروني غير صحيح.";
 elseif(strlen($password)<6)$message="كلمة المرور يجب أن تكون 6 أحرف على الأقل.";
 else{
  $check=$pdo->prepare("SELECT id FROM users WHERE email=?");$check->execute([$email]);
  if($check->fetch())$message="هذا البريد الإلكتروني مسجل مسبقاً.";
  else{
   $hash=password_hash($password,PASSWORD_DEFAULT);
   $stmt=$pdo->prepare("INSERT INTO users(full_name,phone,email,password,state,profession,volunteer_field) VALUES(?,?,?,?,?,?,?)");
   $stmt->execute([$full_name,$phone,$email,$hash,$state,$profession,$volunteer_field]);
   header("Location: login.php?registered=1");exit;
  }
 }
}
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>إنشاء حساب</title><link rel="stylesheet" href="style.css"><style>.form-container{max-width:650px;margin:70px auto;padding:35px;background:#fff;border-radius:15px;box-shadow:0 10px 35px #00000012}.form-container h1{text-align:center;margin-bottom:25px}.form-group{margin-bottom:18px}.form-group label{display:block;margin-bottom:7px;font-weight:bold}.form-group input{width:100%;padding:13px;border:1px solid #ddd;border-radius:8px;font-size:15px}.form-container button{width:100%;border:0}.error{background:#ffe8e8;color:#b00020;padding:12px;border-radius:8px;margin-bottom:20px}</style></head><body><div class="form-container"><h1>إنشاء حساب عضو</h1><?php if($message):?><div class="error"><?=htmlspecialchars($message)?></div><?php endif;?><form method="POST"><div class="form-group"><label>الاسم الكامل *</label><input name="full_name" required></div><div class="form-group"><label>رقم الهاتف *</label><input name="phone" required></div><div class="form-group"><label>البريد الإلكتروني *</label><input type="email" name="email" required></div><div class="form-group"><label>كلمة المرور *</label><input type="password" name="password" required></div><div class="form-group"><label>الولاية</label><input name="state"></div><div class="form-group"><label>المهنة</label><input name="profession"></div><div class="form-group"><label>مجال التطوع</label><input name="volunteer_field"></div><button class="btn btn-primary">إنشاء الحساب</button></form><p style="text-align:center;margin-top:20px">لديك حساب؟ <a href="login.php" style="color:#15946e">تسجيل الدخول</a></p></div></body></html>
