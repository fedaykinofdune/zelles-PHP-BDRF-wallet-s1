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
   $unconfirmed = $balance_array['unconfirmed'];
   $cntr = "0";
   $bgcol = "1";
   $txss = '';
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
      $cntr++;
      if($cntr<="3") {
         $dtx_address = $transactions[$key]['address'];
         $dtx_category = $transactions[$key]['category'];
         $dtx_amount = $transactions[$key]['amount'];
         $dtx_timestamp = $transactions[$key]['time'];
         if(!$dtx_address) { $dtx_address = '<i style="color: 888888;">(unavailable)</i>'; }
         $dtx_time = date("n/j/Y G:i",$dtx_timestamp);
         if($dtx_timestamp!="") {
            if($bgcol=="1") { $bgcol = "2"; $useclass = 'txtda'; } else { $bgcol = "1"; $useclass = 'txtdb'; }
            $dtx_type = '<img src="style/icon_other_large.png" style="width: 72px;">';
            if($dtx_category=="send") { $dtx_type = '<img src="style/icon_sent_large.png" style="width: 72px;">'; }
            if($dtx_category=="receive") { $dtx_type = '<img src="style/icon_received_large.png" style="width: 72px;">'; }
            $txss .= '<tr>
                         <td rowspan="2" style="width: 72px;">'.$dtx_type.'</td>
                         <td style="padding-left: 10px;">'.$dtx_time.'</td>
                         <td align="right">'.$dtx_amount.'</td>
                      </tr><tr>
                         <td colspan="2" style="padding-left: 10px;">'.$dtx_address.'</td>
                      </tr>';
         }
      }
   }
   echo '<div style="padding: 10px;">
            <table style="width: 100%;">
               <tr>
                  <td valign="top">
                     <table>
                        <tr>
                           <td valign="top" style="height: 30px; font-size: 15px; font-weight: bold;" nowrap>'.$pz_coin_name.' Wallet</td>
                           <td valign="top" nowrap></td>
                        </tr><tr>
                           <td valign="top" style="height: 30px; font-size: 11px;" nowrap>Balance:</td>
                           <td valign="top" style="padding-left: 15px; font-size: 11px; font-weight: bold;" nowrap>'.$balance.' '.$pz_coin_initu.'</td>
                        </tr><tr>
                           <td valign="top" style="height: 40px; font-size: 11px;" nowrap>Unconfirmed:</td>
                           <td valign="top" style="padding-left: 15px; font-size: 11px; font-weight: bold;" nowrap>'.$unconfirmed.' '.$pz_coin_initu.'</td>
                        </tr><tr>
                           <td valign="top" style="font-size: 11px;" nowrap>Number of transactions:</td>
                           <td valign="top" style="padding-left: 15px; font-size: 11px;" nowrap>'.$cntr.'</td>
                        </tr>
                     </table>
                  </td>
                  <td valign="top" style="width: 400px;">
                     <table style="width: 100%; font-size: 10px;">
                        <tr>
                           <td colspan="3" valign="top" style="height: 30px; font-size: 11px; font-weight: bold;" nowrap>Recent transactions</td>
                        </tr>'.$txss.'
                     </table>
                  </td>
               </tr>
            </table>
         </div>';
} else {
   echo '<div style="height: 30px;"></div><center>Login to use the wallets.</center>';
}
?>