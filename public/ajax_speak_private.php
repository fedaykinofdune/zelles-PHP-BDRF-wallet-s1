<?php
require"../coinapi_private/data.php";
$getaction = security($_POST['action']);
if(!isset($_SESSION['apiidentity'])) {
   die("n/a");
}
if(isset($_SESSION['apiidentity'])) {
   $EMAIL_INDENT = security($_SESSION['apiidentity']);
   $Query = mysql_query("SELECT email FROM accounts WHERE email='$EMAIL_INDENT'");
   if(mysql_num_rows($Query) == 0) {
      die("n/a");
   }
}
if(isset($_POST['speakprivate'])) {
   $speak = security($_POST['speakprivate']);
   $to = security($_POST['to']);
   if($speak!="") {
      if($udb_chathandle) {
         if($to) {
            $sql = mysql_query("INSERT INTO privatechat (id,date,ip,email,username,room,message,status) VALUES ('','$date','$ip','$udb_email','$udb_chathandle','$to','$speak','viewable')");
         }
      }
   }
}
?>