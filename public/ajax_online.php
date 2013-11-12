<?php
require"../coinapi_private/data.php";

$inDB = mysql_query("SELECT * FROM online WHERE ip='$ip'");
if(!mysql_num_rows($inDB)) {
   mysql_query("INSERT INTO online (id,ip,email,username,user,guest) VALUES('','$ip','$udb_email','$udb_chathandle','2','2')");
} else {
   if($udb_email) {
      mysql_query("UPDATE online SET email='$udb_email' WHERE ip='$ip'");
      mysql_query("UPDATE online SET username='$udb_chathandle' WHERE ip='$ip'");
      mysql_query("UPDATE online SET user='1' WHERE ip='$ip'");
      mysql_query("UPDATE online SET guest='2' WHERE ip='$ip'");
   } else {
      mysql_query("UPDATE online SET user='2' WHERE ip='$ip'");
      mysql_query("UPDATE online SET guest='1' WHERE ip='$ip'");
   }
   mysql_query("UPDATE online SET dt=NOW() WHERE ip='$ip'");
}
// mysql_query("DELETE FROM tz_who_is_online WHERE dt<SUBTIME(NOW(),'0 0:10:0')");
mysql_query("UPDATE online SET user='2' WHERE dt<SUBTIME(NOW(),'0 0:10:0')");
mysql_query("UPDATE online SET guest='2' WHERE dt<SUBTIME(NOW(),'0 0:10:0')");
list($UsersOnline) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM online WHERE user='1'"));
list($GuestsOnline) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM online WHERE guest='1'"));

echo '<script type="text/javascript">
         $(\'#imform\').submit(function() {
            $.ajax({
               data: $(this).serialize(),
               type: $(this).attr(\'method\'),
               url: $(this).attr(\'action\'),
               success: function(response) {
                  $(\'#aim\').append(response);
               }
            });
            return false;
         });
      </script>
      <u>Online:</u> ('.$UsersOnline.')';
$Query = mysql_query("SELECT username FROM online WHERE user='1'");
while($Row = mysql_fetch_assoc($Query)) {
   $list_username = $Row['username'];
   if($list_username!=$udb_chathandle) {
      echo '<form action="ajax_chat_private.php" method="POST" id="imform">
            <input type="hidden" name="handle" value="'.$list_username.'">
            <input type="submit" name="submit" value="'.$list_username.'" style="background: #CBDBDF; border: 0px none #CBDBDF;">
            </form>';
   }
}
$Query = mysql_query("SELECT room FROM newims WHERE handle='$udb_chathandle' and status='waiting'");
if(mysql_num_rows($Query) != 0) {
   $Query = mysql_query("SELECT room FROM newims WHERE handle='$udb_chathandle' and status='waiting'");
   while($Row = mysql_fetch_assoc($Query)) {
      $room_waiting = $Row['room'];
      echo '<script type="text/javascript">
               setTimeout(function() {
                  $("<div>").load("ajax_private_invited.php?room='.$room_waiting.'", function() {
                     $("#aim").append($(this).html());
                  });
               }, 500);

            </script>';
      $sql = mysql_query("UPDATE newims SET status='seen' WHERE room='$room_waiting'");
   }
}
?>