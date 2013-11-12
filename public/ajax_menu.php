<?php
require"../coinapi_private/data.php";
if($udb_email) {
   echo '<div onclick="page_home();return false;" class="tile">
            Public Chatroom
         </div>
         <div onclick="toggle_visibility(\'walletnan\');" class="tile">
            Nanotoken Wallet
         </div>
         <div onclick="page_faucetnan();return false;" class="tile">
            Nanotoken Faucet
         </div>
         <div onclick="page_logout();return false;" class="tile">
            Logout
         </div>';
} else {
   echo '<div onclick="page_home();return false;" class="tile">
            Home
         </div>
         <div onclick="page_login();return false;" class="tile">
            Login
         </div>
         <div onclick="page_register();return false;" class="tile">
            Register
         </div>
         <div onclick="page_faucetnan();return false;" class="tile">
            Nanotoken Faucet
         </div>';
}
?>