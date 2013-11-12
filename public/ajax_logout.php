<?php
require"../coinapi_private/data.php";
session_destroy();
setcookie("identa", '', time()-1000);
setcookie("identa", '', time()-1000, '/');
setcookie("identb", '', time()-1000);
setcookie("identb", '', time()-1000, '/');
echo '<div style="height: 30px;"></div>
      <center>Goodbye!</center>';
?>