<?php 
    if (!empty($_GET)) {
        
        if (isset($_GET['memory']) && $_GET['memory'] == 'like') {
            $fav['trip'] = 'like';
        } elseif (isset($_GET['memory']) && $_GET['memory'] == 'something') {
            $fav['trip'] = 'like';
            $fav['something'] = 'like';
        } elseif (isset($_GET['memory']) && $_GET['memory'] == 'love') {
            $fav['trip'] = 'like';
            $fav['something'] = 'like';
            $fav['love'] = 'like';
        } elseif ($_GET['memory'] && $_GET['memory'] == 'tradition') {
            $fav['trip'] = 'like';
            $fav['something'] = 'like';
            $fav['love'] = 'like';
            $fav['tradition'] = 'like';
        } elseif (isset($_GET['memory']) && $_GET['memory'] == 'all') {
            $fav['trip'] = 'like';
            $fav['something'] = 'like';
            $fav['love'] = 'like';
            $fav['tradition'] = 'like';
            $fav['all'] = 'like';
        }
    }



 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <title>question</title>
 </head>
 <body>
    <div align="center">
      <p style="font-size: 50px;">ここで質問です！！！</p>
    </div>
    <div>
      
      
    </div>
    <div>
      <?php if (isset($fav['trip']) && $fav['trip'] == 'like') { ?>
        <p align="center" style="color: orange; font-size: 30px;">あなたは,旅行が好きですか？</p>
      <?php } ?>
      <?php if (isset($fav['something']) && $fav['something']== 'like') { ?>
      <p align="center" style="color: orange; font-size: 30px;">思い出に残る何かを経験して見たいと思いませんか？</p>
      <?php } ?>
      <?php if (isset($fav['love']) && $fav['love'] == 'like') {?>
        <p align="center" style="color: orange; font-size: 30px;">ハートを鷲掴みたい相手はいますか？</p>
      <?php } ?>
      <?php if (isset($fav['tradition']) && $fav['tradition'] == 'like') { ?>
        <p align="center" style="color: orange; font-size: 30px;">違う街なのだからそこの文化に触れて見たいと考えたことはありませんか？</p>
      <?php } ?>
      <?php if (isset($fav['all']) && $fav['all'] == 'like') { ?>
        <p align="center" style="color: purple; font-size: 50px;">私は全て当てはまります！！</p>
      <?php } ?>
      <form action="" method="GET">
        <input type="hidden" name="memory" value="like">
        <input type="submit" value="その1"style="margin:0px; float:left;">
      </form>
      <form action="" method="GET">
      <input type="hidden" name="memory" value="something">
        <input type="submit" value="その2"style="margin:0px; float:left;">
      </form>
    </div>
    <div>
      <form action="" method="GET">
        <input type="hidden" name="memory" value="love">
        <input type="submit" value="その3"style="margin:0px; float:left;">
      </form>
    </div>
    <div>
      <form action="" method="GET">
        <input type="hidden" name="memory" value="tradition">
        <input type="submit" value="その4"style="margin:0px; float:left;">
    </form>
    </div>
    <div>
    <?php if (isset($)) { ?>
      <form action="" method="GET">
        <input type="hidden" name="memory" value="all">
        <input type="submit" value="結果" style="color:red;"style="margin:0px; float:left;">
    </form>
    </div>
    <?php if (isset($_GET['memory']) && $_GET['memory'] == 'all') { ?>
    <form action="jo3.php" method="POST" align="right">
      <input type="submit" value="次へ" style="width:100%;padding:10px;font-size:30px; background-color: pink;" >
    <?php } ?>
    </form>
    

    
    
    
    
    
 </body>
 </html>