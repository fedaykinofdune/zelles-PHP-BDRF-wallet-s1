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
   echo '<script type="text/javascript">
            $(\'#receiveform\').submit(function() {
               $.ajax({
                  data: $(this).serialize(),
                  type: $(this).attr(\'method\'),
                  url: $(this).attr(\'action\'),
                  success: function(response) {
                     $(\'#receiveresponce\').html(response);
                  }
               });
               return false;
            });
         </script>
         <span style="font-size: 15px; font-weight: bold;">'.$pz_coin_name.' Receiving Addresses</span>
         <div style="margin-top: 10px; margin-right: 4px;">
         <div class="addressbookdiv">
         <table class="addressbooktable">
            <tr>
               <td align="center" class="addressbooktdt">Label</td>
               <td align="center" class="addressbooktdt" id="rightside">Address</td>
               <td class="addressbooktdblock"></td>
            </tr>
         </table>
         <div class="addressbookscroll">
         <table class="addressbooktable">';
            $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getaccountaddresses&acnt='.$udb_email.'&sid=BDRFM';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $json_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json_feed = curl_exec($ch);
            curl_close($ch);
            $addressbook_array = json_decode($json_feed, true);
            $addresses = $addressbook_array['addresses'];
            if($addresses=="") {
               $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getnewaddress&acnt='.$udb_email.'&sid=BDRFM';
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $json_url);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               $json_feed = curl_exec($ch);
               $addressbook_array = json_decode($json_feed, true);
               $address = $addressbook_array['address'];
               curl_close($ch);
               echo '<tr>
                        <td class="addressbooktda"></td>
                        <td class="addressbooktda" id="rightside">'.$address.'</td>
                     </tr>';
            } else {
               $bgcol = "1";
               $useclass = 'addressbooktdb';
               foreach($addresses as $address) {
                  if($bgcol=="1") { $bgcol = "2"; $useclass = 'addressbooktda'; } else { $bgcol = "1"; $useclass = 'addressbooktdb'; }
                  echo '<tr>
                           <td class="'.$useclass.'"></td>
                           <td class="'.$useclass.'" id="rightside">'.$address.'</td>
                        </tr>';
               }
            }
   echo '</table>
         </div>
         </div>
         <form action="ajax_wallet_receive_request.php" method="POST" id="receiveform" style="margin-top: 10px;">
         <input type="hidden" name="wallet" value="'.$pz_coin_initl.'">
         <input type="hidden" name="newaddress" value="go">
         <input type="submit" name="buttonnewaddress" value="" class="buttonnewaddress">
         </form>
         <div id="receiveresponce"></div>
         </div>';
} else {
   echo '<div style="height: 30px;"></div><center>Login to use the wallets.</center>';
}
?>