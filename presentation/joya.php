<?php 
    
      if (!empty($_POST['food'])) {
           $good['food'] = 'nice';
      }

      if (!empty($_POST['tuyomi'])) {
           $good['tuyomi'] = 'nice';
      }

      if (!empty($_POST['hanabi'])) {
           $good['hanabi'] = 'nice';
      }




 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
  <meta charset="utf-8">
   <title>joya.php</title>
 </head>
 <body background="../photos_name/1470643998.jpg">
   <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 content-margin-top">
          
          <div align="center" style="color: white; font-size: 40px;">
              <p>田舎の強み</p>
              <p>その街の中の情報にはそれなりに強い。<br>そして私たちにとってはあたりまえだからこそ<br>他の街から来た人たちにはわからない。</p>
              <p>例えば</p>
         </div>
             <div align="center" style="color: orange; font-size: 40px;">
                     <?php if (isset($good['food']) && $good['food'] == 'nice') { ?>
                        <p><span align="center" style="color: orange; font-size: 40px;">田舎だからこそ、知られていない住人のおすすめのご飯屋さん</span></p>
                     <?php } ?>
                      
                      <?php if (isset($good['tuyomi']) && $good['tuyomi'] == 'nice') { ?>
                         <p><span align="center" style="color: orange; font-size: 40px;">田舎ならではの蛍の名スポット</span></p>
                     <?php } ?>
                     
                      <?php if (isset($good['hanabi']) && $good['hanabi'] == 'nice') { ?>
                        <p><span align="center" style="color: orange; font-size: 40px;">花火大会などの隠れたイベント</span></p>
                     <?php } ?>
                      
                      

                  <form action="" method="POST">

                    <input type="hidden" name="food" value="1">
                    <input type="submit" value="強み１">
                  </form>
                  <form action="" method="POST">
                    <input type="hidden" name="tuyomi" value="2">
                    <input type="submit" value="強み２">
                  </form>
                  <form action="" method="POST">
                    <input type="hidden" name="hanabi" value="3">
                    <input type="submit" value="強み３">
                  </form>
             </div>
             <div align="right">
                <form action="jo2.php" method="POST">
                  <input type="submit" value="次へ" style="width:20%;padding:10px;font-size:30px; background-color: pink;">
                </form>
             </div>
         
        </div>
      </div>
   </div>
 </body>
 </html>