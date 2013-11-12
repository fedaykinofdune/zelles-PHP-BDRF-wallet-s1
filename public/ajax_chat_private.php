<?php
require"../coinapi_private/data.php";
if($udb_email) {
   $pm_handle = security($_POST['handle']);
   $pm_rand = rand(100,999);
   $im_name = $pm_handle.$pm_rand;
   $sql = mysql_query("INSERT INTO newims (id,date,ip,email,username,room,handle,status) VALUES ('','$date','$ip','$udb_email','$udb_chathandle','$im_name','$pm_handle','waiting')");
   echo '<script type="text/javascript">
            $(\'#'.$im_name.'privatechatter\').submit(function() {
               $.ajax({
                  data: $(this).serialize(),
                  type: $(this).attr(\'method\'),
                  url: $(this).attr(\'action\'),
                  success: function(response) {
                     $(\'#'.$im_name.'speakprivate\').val(\'\');
                  }
               });
               return false;
            });
            setTimeout(function() {
               $("#'.$im_name.'privatechatroom").load("ajax_chatroom_private.php?to='.$im_name.'");
               $(\'#'.$im_name.'privatechatroom\').scrollTop($(\'#'.$im_name.'privatechatroom\')[0].scrollHeight);
            }, 500);
            setInterval(function () {
               $("#'.$im_name.'privatechatroom").load("ajax_chatroom_private.php?to='.$im_name.'");
               $(\'#'.$im_name.'privatechatroom\').scrollTop($(\'#'.$im_name.'privatechatroom\')[0].scrollHeight);
            }, 1500);
            $(function() {
               $("#'.$im_name.'").draggable();
            });
         </script>
         <div id="'.$im_name.'" class="im">
         <table class="imt">
            <tr>
               <td class="imh">
                  <table style="width: 100%; height: 100%;">
                     <tr>
                        <td style="font-weight: bold;">Private Messenger</td>
                        <td align="right" style="font-weight: bold;"><a onclick="hide_pm(\''.$im_name.'\');" style="text-decoration: none; color: #000000;">[X]</a></td>
                     </tr>
                  </table>
               </td>
            </tr><tr>
               <td valign="top" class="imb">
                  <div id="'.$im_name.'privatechatroom" style="width: 100%; height: 100%; background: #FFFFFF; border: 0px none #FFFFFF; overflow-y: scroll;">
                     Loading...
                  </div>
               </td>
            </tr><tr>
               <td class="imf">
                  <form action="ajax_speak_private.php" method="POST" id="'.$im_name.'privatechatter">
                  <input type="hidden" name="to" value="'.$im_name.'">
                  <table style="width: 100%; height: 30px;">
                     <tr>
                        <td style="width: 100%; font-weight: bold;"><input type="text" id="'.$im_name.'speakprivate" name="speakprivate" style="width: 100%; height: 30px"></td>
                        <td align="right" style="width: 60px;"><input type="submit" name="submit" value="Send" style="width: 60px; height: 30px; background: #07C6FF; border: 1px solid #07C6FF;"></td>
                     </tr>
                  </table>
                  </form>
               </td>
            </tr>
         </table>
         </div>';
} else {
   echo 'Login to private message.';
}
?>