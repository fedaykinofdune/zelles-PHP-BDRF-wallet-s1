<?php
require"../coinapi_private/data.php";
if($udb_email) {
   echo 'No need to login, you are already logged in.';
} else {
   echo '<div style="height: 30px;"></div>
         <center>
         <form action="http://bdrf.info" method="POST">
         <input type="hidden" name="action" value="login">
         <table style="width: 300px; font-size: 11px;">
            <tr>
               <td colspan="2" align="left" style="height: 30px; font-weight: bold;">Login:</td>
            </tr><tr>
               <td align="right" style="height: 30px; padding-right: 15px;" nowrap>Email</td>
               <td align="right" style="height: 30px;"><input type="text" name="email" placeholder="Email" style="height: 20px; width: 100%;"></td>
            </tr><tr>
               <td align="right" style="height: 30px; padding-right: 15px;" nowrap>Password</td>
               <td align="right" style="height: 30px;"><input type="password" name="password" placeholder="Password" style="height: 20px; width: 100%;"></td>
            </tr><tr>
               <td colspan="2" style="height: 30px;" align="right"><input type="submit" name="submit" value="Login"></td>
            </tr>
         </table>
         </form>
         </center>';
}
?>