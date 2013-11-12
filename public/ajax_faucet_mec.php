<?php
require"../coinapi_private/data.php";
$timestamp_now = strtotime('now');
$timestamp_tomorrow = strtotime('tomorrow');
$day_today_day = date('l',$timestamp_now);
$date_today_date = date('dS',$timestamp_now);
$day_today_time = date('g:i a',$timestamp_now);
$day_today = $day_today_time.' on '.$day_today_day.', the '.$date_today_date;
$date_tomorrow_date = date('dS',$timestamp_tomorrow);
$day_tomorrow_day = date('l',$timestamp_tomorrow);
$day_tomorrow = $day_tomorrow_day.', on the '.$date_tomorrow_date;

echo '<script type="text/javascript">
         $(document).ready(function(){
            $("#coina").everyTime(10, function(){
               $("#coina").animate({left:"80%"}, 5000).animate({left:"10"}, 5000);
            });
            $("#coinb").everyTime(10, function(){
               $("#coinb").animate({left:"80%"}, 4000).animate({left:"10"}, 4000);
            });
            $("#coinc").everyTime(10, function(){
               $("#coinc").animate({left:"80%"}, 3000).animate({left:"10"}, 3000);
            });
         });
         $(\'#faucetform\').submit(function() {
            $.ajax({
               data: $(this).serialize(),
               type: $(this).attr(\'method\'),
               url: $(this).attr(\'action\'),
               success: function(response) {
                  $(\'#faucetresponce\').html(response);
               }
            });
            return false;
         });
      </script>
      <table style="width: 100%; height: 100px;">
         <tr>
            <td align="center">
               <div id="faucetresponce"></div>
               <table>
                  <tr>
                     <td nowrap>Megacoin Address:</td>
                     <td style="padding-left: 10px;" nowrap><input type="text" name="setaddr" id="setaddr" placeholder="MDHdcuvRbdMHFxFhH9kaK12JaNDxpYsNVq" onclick="setaddr()" onkeyup="setaddr()" onkeydown="setaddr()" onchange="setaddr()" style="width: 400px; height: 22px;"></td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      <form method="POST" action="ajax_faucet_mec_request.php" id="faucetform">
      <input type="hidden" id="addr" name="addr" value="">
      <div class="coin_box_rail">
         <div class="coin_box">
            <div id="coina" class="coin"><input type="submit" name="submit" value="" class="targetmec"></div>
         </div>
         <div class="coin_box">
            <div id="coinb" class="coin"><input type="submit" name="submit" value="" class="targetmec"></div>
         </div>
         <div class="coin_box">
            <div id="coinc" class="coin"><input type="submit" name="submit" value="" class="targetmec"></div>
         </div>
      </div>
      </form>
      <center><p>It is <b>'.$day_today.'</b>. Request again <b>'.$day_tomorrow.'</b></p></center>';
?>