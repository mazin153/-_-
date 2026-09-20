<?php
require_once "db.php";$message="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $name=trim($_POST["name"]);$email=trim($_POST["email"]);$password=$_POST["password"];
 if(!$name||!$email||!$password)$message="يرجى تعبئة جميع البيانات.";
 elseif(strlen($password)<6)$message="كلمة المرور يجب أن تكون 6 أحرف على الأقل.";
 else{
  try{$hash=password_hash($password,PASSWORD_DEFAULT);$stmt=$pdo->prepare("INSERT INTO users(full_name,phone,email,password,role,status) VALUES(?,?,?,?, 'admin','active')");$stmt->execute([$name,"0000000000",$email,$hash]);$message="تم إنشاء حساب المدير بنجاح. احذف ملف install.php الآن.";}
  catch(PDOException $e){$message="قد يكون البريد الإلكتروني مستخدماً مسبقاً.";}
 }
}
?><!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>إعداد المدير</title><link rel="stylesheet" href="style.css"><style>.install{max-width:550px;margin:80px auto;padding:35px;background:#fff;border-radius:15px;box-shadow:0 10px 35px #00000012}.install input{width:100%;padding:13px;margin:8px 0 18px;border:1px solid #ddd;border-radius:8px}.install button{width:100%;border:0}</style></head><body><div class="install"><h1>إعداد مدير المنظمة</h1><p>استخدم هذه الصفحة مرة واحدة فقط لإنشاء حساب المدير.</p><?php if($message):?><p style="padding:12px;background:#e8f6f0"><?=htmlspecialchars($message)?></p><?php endif;?><form method="POST"><label>اسم المدير</label><input name="name" required><label>البريد الإلكتروني</label><input type="email" name="email" required><label>كلمة المرور</label><input type="password" name="password" required><button class="btn btn-primary">إنشاء المدير</button></form></div></body></html>
