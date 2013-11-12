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
   echo '<span style="font-size: 15px; font-weight: bold;">'.$pz_coin_name.' Transactions</span>
         <div style="margin-top: 10px; margin-right: 4px;">
         <div class="txdiv">
         <table style="width: 100%;">
            <tr>
               <td class="txtdt"></td>
               <td class="txtdt">Time</td>
               <td class="txtdt">Type</td>
               <td class="txtdt">Address</td>
               <td class="txtdt">Amount</td>
            </tr>';
   $bgcol = "1";
   $useclass = 'txtdb';
   $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=listtransactions&acnt='.$udb_email.'&sid=BDRFM';
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $json_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $json_feed = curl_exec($ch);
   curl_close($ch);
   $tx_array = json_decode($json_feed, true);
   $transactions = $tx_array['transactions'];
   function invenDescSort($item1,$item2) {
      if ($item1['time'] == $item2['time']) return 0;
      return ($item1['time'] < $item2['time']) ? 1 : -1;
   }
   usort($transactions,'invenDescSort');
   foreach($transactions as $key => $value) {
      $dtx_confirmations = $transactions[$key]['confirmations'];
      $dtx_address = $transactions[$key]['address'];
      $dtx_category = $transactions[$key]['category'];
      $dtx_amount = $transactions[$key]['amount'];
      $dtx_timestamp = $transactions[$key]['time'];
      if(!$dtx_address) { $dtx_address = '<i style="color: 888888;">(unavailable)</i>'; $dtx_confirmations = '10'; }
      if($dtx_timestamp!="") {
         $dtx_time = date("n/j/Y G:i",$dtx_timestamp);
         if($bgcol=="1") { $bgcol = "2"; $useclass = 'txtda'; } else { $bgcol = "1"; $useclass = 'txtdb'; }
         $dtx_type = 'Moved';
         if($dtx_category=="send") { $dtx_type = 'Sent to'; }
         if($dtx_category=="receive") { $dtx_type = 'Received with'; }
         if($dtx_confirmations>"6") { $dtx_confirmations = "&#8730;"; }
         echo '<tr>
                  <td class="'.$useclass.'">'.$dtx_confirmations.'</td>
                  <td class="'.$useclass.'">'.$dtx_time.'</td>
                  <td class="'.$useclass.'">'.$dtx_type.'</td>
                  <td class="'.$useclass.'">'.$dtx_address.'</td>
                  <td align="right" class="'.$useclass.'">'.$dtx_amount.'</td>
               </tr>';
      }
   }
   echo '</table>
         </div>
         </div>';
} else {
   echo '<div style="height: 30px;"></div><center>Login to use the wallets.</center>';
}
?>