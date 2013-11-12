<?php
require"../coinapi_private/data.php";
if($udb_email) {
   $wallet_type = security($_GET['wallet']);
   if(($wallet_type!="ftc")&&($wallet_type!="ltc")&&($wallet_type!="mec")&&($wallet_type!="nan")) {
      die('<div style="height: 30px;"></div><center>Invalid wallet.</center>');
      exit;
   }
   if($wallet_type=="ftc") {
      $pz_coin_name = 'Feathercoin';
      $pz_coin_initl = 'ftc';
      $pz_coin_initu = 'FTC';
   }
   if($wallet_type=="ltc") {
      $pz_coin_name = 'Litecoin';
      $pz_coin_initl = 'ltc';
      $pz_coin_initu = 'LTC';
   }
   if($wallet_type=="mec") {
      $pz_coin_name = 'Megacoin';
      $pz_coin_initl = 'mec';
      $pz_coin_initu = 'MEC';
   }
   if($wallet_type=="nan") {
      $pz_coin_name = 'Nanotoken';
      $pz_coin_initl = 'nan';
      $pz_coin_initu = 'NAN';
   }

   $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getbalance&acnt='.$udb_email.'&sid=BDRFM';
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $json_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $json_feed = curl_exec($ch);
   curl_close($ch);
   $balance_array = json_decode($json_feed, true);
   $balance = $balance_array['balance'];

   echo '<script type="text/javascript">
            $(\'#sendform\').submit(function() {
               $.ajax({
                  data: $(this).serialize(),
                  type: $(this).attr(\'method\'),
                  url: $(this).attr(\'action\'),
                  success: function(response) {
                     $(\'#sendresponce\').html(response);
                  }
               });
               return false;
            });
         </script>
         <span style="font-size: 15px; font-weight: bold;">Send '.$pz_coin_name.'s</span>
         <div style="margin-top: 10px; margin-right: 4px;">
         <form action="ajax_wallet_send_request.php" method="POST" id="sendform">
         <input type="hidden" name="wallet" value="'.$pz_coin_initl.'">
         <table style="width: 100%;">
            <tr>
               <td>
                  <table style="width: 100%; font-size: 11px; border: 1px solid #C0C6C9;">
                     <tr>
                        <td style="height: 34px; width: 60px; padding: 10px;" nowrap>Pay To:</td>
                        <td style="height: 34px; padding: 10px;" nowrap><input type="text" name="sendto" placeholder="Enter a '.$pz_coin_name.' address" style="width: 100%; height: 24px;"></td>
                     </tr><tr>
                        <td style="height: 34px; padding: 10px;" nowrap>Amount:</td>
                        <td style="height: 34px; padding: 10px;" nowrap><input type="text" name="sendamount" style="width: 160px; height: 24px;"></td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
         <table style="width: 100%; font-size: 11px; margin-top: 10px;">
            <tr>
               <td>Balance: '.$balance.' '.$pz_coin_initu.'</td>
               <td align="right">
                  <input type="hidden" name="send" value="go">
                  <input type="submit" name="submit" value="" class="buttonsend">
               </td>
            </tr>
         </table>
         </form>
         </div>
         <div id="sendresponce"></div>';
} else {
   echo '<div style="height: 30px;"></div><center>Login to use the wallets.</center>';
}
?>