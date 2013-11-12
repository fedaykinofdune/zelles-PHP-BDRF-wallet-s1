<?php
require"../coinapi_private/data.php";
$getaction = security($_POST['action']);
if(!$udb_email) {
   if($getaction=="login") {
      $login_email = security($_POST['email']);
      $login_password = security($_POST['password']);
      if($login_email) {
         if($login_password) {
            $login_password = substr($login_password, 0, 30);
            $login_password = md5($login_password);
            $Query = mysql_query("SELECT email FROM accounts WHERE email='$login_email'");
            if(mysql_num_rows($Query) == 1) {
               $Query = mysql_query("SELECT email, password, status, banned, pub_key, priv_key FROM accounts WHERE email='$login_email'");
               while($Row = mysql_fetch_assoc($Query)) {
                  $login_db_email = $Row['email'];
                  $login_db_password = $Row['password'];
                  $login_db_status = $Row['status'];
                  $login_db_banned = $Row['banned'];
                  $login_db_pub_key = $Row['pub_key'];
                  $login_db_priv_key = $Row['priv_key'];
                  if($login_password==$login_db_password) {
                     if($login_db_status=="1") {
                        if($login_db_banned!="1") {
                           $_SESSION['apiidentity'] = $login_db_email;
                           setcookie("identa",$login_db_pub_key,time() + (10 * 365 * 24 * 60 * 60));
                           setcookie("identb",$login_db_priv_key,time() + (10 * 365 * 24 * 60 * 60));
                           header('Location: http://bdrf.info');
                           $onloader = ' onload="alert(\'Logged in!\')"';
                        } else {
                           $onloader = ' onload="alert(\'That account has been banned.\')"';
                        }
                     } else {
                        $onloader = ' onload="alert(\'You have not activated your account\nusing the activation email.\')"';
                     }
                  } else {
                     $onloader = ' onload="alert(\'Invalid password!\')"';
                  }
               }
            } else {
               $onloader = ' onload="alert(\'Account does not exist!\')"';
            }
         } else {
            $onloader = ' onload="alert(\'No password was entered!\')"';
         }
      } else {
         $onloader = ' onload="alert(\'No email was entered!\')"';
      }
   }
   if($getaction=="register") {
      $register_email = security($_POST['email']);
      $register_password = security($_POST['password']);
      $register_conpassword = security($_POST['conpassword']);
      if($register_email) {
         if($register_password) {
            if($register_password==$register_conpassword) {
               $register_password = substr($register_password, 0, 30);
               $register_password = md5($register_password);
               $register_pub_key = pubkeygen();
               $register_priv_key = pubkeygen();
               $Query = mysql_query("SELECT email FROM accounts WHERE email='$register_email'");
               if(mysql_num_rows($Query) == 0) {
                  $sql = mysql_query("INSERT INTO accounts (id,date,ip,email,password,status,banned,pub_key,priv_key) VALUES ('','$date','$ip','$register_email','$register_password','1','0','$register_pub_key','$register_priv_key')");
                  $onloader = ' onload="alert(\'Account created! You can login now.\')"';
               } else {
                  $onloader = ' onload="alert(\'There is already an account using that email!\')"';
               }
            } else {
               $onloader = ' onload="alert(\'Passwords do not match!\')"';
            }
         } else {
            $onloader = ' onload="alert(\'No password was entered!\')"';
         }
      } else {
         $onloader = ' onload="alert(\'No email was entered!\')"';
      }
   }
}
?>
<html>
<head>
   <title>BDRF.info</title>
   <link rel="icon" type="image/png" href="style/favicon.png">
   <link rel="stylesheet" type="text/css" href="style/style.css">
   <script type="text/javascript" src="style/jquery-1.9.1.js"></script>
   <script type="text/javascript" src="style/jquery-ui.js"></script>
   <script type="text/javascript" src="style/jquery.timers-1.1.2.js"></script>
   <script type="text/javascript">
      function page_home(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_home.php');
      }
      function page_login(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_login.php');
      }
      function page_register(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_register.php');
      }
      function page_faucetnan(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_faucet_nan.php');
      }
      function page_walletnan_overview(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_overview.php?wallet=nan');
      }
      function page_walletnan_send(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_send.php?wallet=nan');
      }
      function page_walletnan_receive(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_receive.php?wallet=nan');
      }
      function page_walletnan_transactions(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_transactions.php?wallet=nan');
      }
      function page_logout(){
         $('#pagebody').html('<div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_logout.php');
      }
      setTimeout(function () {
         $("#menu").load("ajax_menu.php");
         $("#pagebody").load("ajax_home.php");
         $("#online").load("ajax_online.php");
      }, 100);
      setInterval(function () {
         $("#menu").load("ajax_menu.php");
         $("#online").load("ajax_online.php");
      }, 2000);
   </script>
   <script type="text/javascript">
      function toggle_visibility(id) {
         var e = document.getElementById(id);
         if(e.style.display == 'block')
            e.style.display = 'none';
         else
            e.style.display = 'block';
      }
      function hide_pm(id) {
         var e = document.getElementById(id);
         e.style.display = 'none';
      }
      function setaddr() {
         document.getElementById('addr').value = document.getElementById('setaddr').value;
      }
   </script>
</head>
<body<?php if(isset($onloader)) { echo $onloader; } ?>>
   <table class="content">
      <tr>
         <td colspan="3" class="north-side" style="height: 30px;">
            <a href="http://bdrf.info" class="site-title">BDRF</a>
         </td>
      </tr><tr>
         <td valign="top" class="west-side">
            <div id="menu">
               <div class="tile">
                  Loading...
               </div>
            </div>
         </td>
         <td valign="top" class="central">
            <table id="walletnan" class="walletmenu">
               <tr>
                  <td class="walletmenutd"><b>Nanotoken Menu</b></td>
                  <td onclick="page_walletnan_overview();toggle_visibility('walletnan');return false;" class="walletmenutd">Overview</td>
                  <td onclick="page_walletnan_send();toggle_visibility('walletnan');return false;" class="walletmenutd">Send</td>
                  <td onclick="page_walletnan_receive();toggle_visibility('walletnan');return false;" class="walletmenutd">Receive</td>
                  <td onclick="page_walletnan_transactions();toggle_visibility('walletnan');return false;" class="walletmenutd">Transactions</td>
               </tr>
            </table>
            <div id="pagebody">
               <div style="height: 30px;"></div><center><img src="style/loading.gif" /></center>
            </div>
         </td>
         <td valign="top" align="right" class="east-side">
            <div align="left" class="online">
               <div id="online">
                  Loading...
               </div>
            </div>
         </td>
      </tr>
   </table>
   <div id="aim"></div>
</body>
</html>