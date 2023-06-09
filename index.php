<?php
// Koneksi database
$db = pg_connect("host=localhost port=5432 dbname=db_coord user=postgres password=postgres");

//Boleh Diubah
$skala = 250; // 1 : skala
$grid_gambar = 5; // cm
$x_kertas = 42; // cm
$y_kertas = 29.7; // cm

$css_x_kertas = '50rem';
$css_y_kertas = (50/$x_kertas*$y_kertas).'rem' ;

$css_boxed = ($grid_gambar/$x_kertas*50 ).'rem';

$grid_asli = $skala * $grid_gambar; // cm
$grid_asli = $grid_asli/100; // m


  if(isset($_GET['point'])) {
    $point = $_GET['point'];
    if(is_numeric($point)){
      $sql_id = "SELECT id FROM coord
                  WHERE point = {$_GET['point']};";
      $result_id = pg_query($db, $sql_id);
      $id = pg_fetch_assoc($result_id);
      if($id){
        $id = $id['id'];
      } else{
        $id = 1;
      }
    }else{
      $point = 1;
      $id = 1;
    }
  }else{
    header("Location: /?point=1101");
  }

      $queryTables = "SELECT * FROM coord WHERE point={$point}";
      $resultTables = pg_query($db, $queryTables);
      $row = pg_fetch_assoc($resultTables);
      if(!$row){
        $row = [
          "id" => 1,
          "point" => '',
          "x" => '',
          "y" => '',
          "z" => '',
          "code" => "Not Found"
        ];
        $x = '';
        $y = '';
        $z = '';
        $code = '';
        

        $xa = '';
        $xb = '';
        $ya = '';
        $yb = '';

        $x1 = '';
        $x2 = '';
        $y1 = '';
        $y2 = '';

        $css_x1 = '10rem';
        $css_x2 = '10rem';
        $css_y1 = '10rem';
        $css_y2 = '10rem';

      } else{
        $x = floatval($row['x']);
        $y = floatval($row['y']);
        $z = floatval($row['z']);
        $code = $row['code'];

        $xa = (floor($x/$grid_asli))*$grid_asli;
        $xb = $xa + $grid_asli;

        $ya = (floor($y/$grid_asli))*$grid_asli;
        $yb = $ya + $grid_asli;

        $x1 = round((($x - $xa)/$grid_asli)*$grid_gambar,2).' cm';
        $x2 = round((($xb - $x)/$grid_asli)*$grid_gambar,2).' cm';

        $y1 = round((($yb - $y)/$grid_asli)*$grid_gambar,2).' cm';
        $y2 = round((($y - $ya)/$grid_asli)*$grid_gambar,2).' cm';

        $css_x1 = round((($x - $xa)/$grid_asli)*20,3).'rem';
        $css_x2 = round((($xb - $x)/$grid_asli)*20,3).'rem';

        $css_y1 = round((($yb - $y)/$grid_asli)*20,3).'rem';
        $css_y2 = round((($y - $ya)/$grid_asli)*20,3).'rem';

        $css_pos_y = round(((($yb - $y)/$grid_asli)*20)-2,3) .'rem';
      }  

  if(is_float($x) && is_float($y)){
    if ($x-$xa > $grid_asli/2){
      if ($y-$ya < $grid_asli/2){
        $pos_tinggi = 'pos-a';
      } else{
        $pos_tinggi = 'pos-c';
      }
    } else{
      if ($y-$ya < $grid_asli/2){
        $pos_tinggi = 'pos-b';
      } else{
        $pos_tinggi = 'pos-d';
      }
    }
  }else{
    $pos_tinggi='';
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" >
  <meta name="vieport" content="width=device-width,initial-scale=1.0">
   <title>Plotting Gaes</title>
   <link rel="icon" href="https://img.icons8.com/external-soft-fill-juicy-fish/60/external-land-civil-engineering-soft-fill-soft-fill-juicy-fish-2.png" type="image/ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- <link rel="icon" href="https://img.icons8.com/external-soft-fill-juicy-fish/60/external-land-civil-engineering-soft-fill-soft-fill-juicy-fish-2.png" type="image/ico"> -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <style>
      :root {
        --x1: <?=$css_x1?>;
        --x2: <?=$css_x2?>;
        --y1: <?=$css_y1?>;
        --y2: <?=$css_y2?>;
        --x_sheet: <?=$css_x_kertas?>;
        --y_sheet: <?=$css_y_kertas?>;
        --size-box: <?=$css_boxed?>;
        --pos-y : <?=$css_pos_y?>;
      }
    </style>
    
   <link rel="stylesheet" href="style.css">
  </head>
<body>
  <div class="container">
  <nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <!-- <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> -->
      <i class="fa fa-map-marker fa-fw"></i>
      Yuk Plotting!
    </a>
  </div>
</nav>

    <!-- Content here -->
    

    <div class="alert alert-primary d-flex justify-content-center" role="alert">
      <!-- <div class="kotak"></div> -->
      <div class="kotak">
        <div class="kotak11 kotakan"></div>
        <div class="kotak12 kotakan"></div>
        <div class="kotak21 kotakan"></div>
        <div class="kotak22 kotakan"></div>
        <div class="x1"><p><?=$x1?></p></div>
        <div class="x2"><p><?=$x2?></p></div>
        <div class="y1"><p><?=$y1?></p></div>
        <div class="y2"><p><?=$y2?></p></div>
        <div class="ya"><h3><?=$ya?></h3></div>
        <div class="yb"><h3><?=$yb?></h3></div>
        <div class="xa"><h3><?=$xa?></h3></div>
        <div class="xb"><h3><?=$xb?></h3></div>
        <div class="garis1"></div>
        <div class="garis2"></div>
        <div class="<?=$pos_tinggi; ?>"><?=$z; ?></div>
      </div>
    </div>
    

    <div class="alert alert-success" role="alert">

    <form class="row g-3 row align-items-center" method="get" action="">
      
      <?php
        $previous = $id - 1;
        $nexts = $id + 1;
        
        $sql_prev = "SELECT point FROM coord
                   WHERE id =  {$previous}
                   LIMIT 1;";
        $result_prev = pg_query($db, $sql_prev);
        $prev = pg_fetch_assoc($result_prev);
        if($prev){
          $prev = $prev['point'];
        }else{
          $prev = '1101';
        }

        $sql_next = "SELECT point FROM coord
                   WHERE id =  {$nexts}
                   LIMIT 1;";
        $result_next = pg_query($db, $sql_next);
        $next = pg_fetch_assoc($result_next);

        $sql_last = "SELECT point FROM coord
                     ORDER BY id DESC
                     LIMIT 1;";
        $result_last = pg_query($db, $sql_last);
        $last = pg_fetch_assoc($result_last);
        if($next){
          $next = $next['point'];
        }else{
          $next = $last['point'];
        }

        $sql_count_all = "SELECT COUNT(*) FROM coord;";
        $result_count_all = pg_query($db, $sql_count_all);
        $count_all = pg_fetch_assoc($result_count_all);
        $count_all = intval($count_all['count']);
        
        $sql_count_plot = "SELECT COUNT(*) FROM coord
                           WHERE status = 'plot';";
        $result_count_plot = pg_query($db, $sql_count_plot);
        $count_plot = pg_fetch_assoc($result_count_plot);
        $count_plot = intval($count_plot['count']);

        $progress = round(($count_plot/$count_all)*100,2);
      ?>

      <div class="col-auto mb-3">
        <button type="submit" class="btn btn-primary">OK</button>
      </div>
      <div class="col-auto mb-3">
        <label for="point" class="visually-hidden">No Titik</label>
        <input type="number" class="form-control" id="point" name="point" placeholder="Point" value="<?=$point?>">
      </div>
      <div class="col-auto mb-3">
        <a class="btn btn-secondary" href="?point=<?=$prev?>" role="button" id="prev"><</a>
      </div>
      <div class="col-auto mb-3">
        <a class="btn btn-secondary" href="?point=<?=$next?>" role="button" id="next">></a>
      </div> 
      <div class="col text-center mb-3">
        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width:<?=$progress?>%;" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100"><?=$progress?>%</div>
        </div>
      </div>
    </form>
    <!-- <?=  'X : ' .$row['x']. '<br>Y : ' .$row['y'] . '<br>Elevation : ' . $row['z'] . '<br>Code : ' . $row['code'] ?> -->
    <table class="table table-dark">
      <thead>
            <?php
            // Kode PHP untuk mengambil data dari database
            if(is_numeric($_GET['point'])){
              $sql = "SELECT point,x,y,z,code FROM coord
                      WHERE point = {$_GET['point']};";
              $result = pg_query($db, $sql);

              $sql_status = "SELECT status FROM coord
                      WHERE point = {$_GET['point']};";
              $result_status = pg_query($db, $sql_status);

              $sql_before = "SELECT point,x,y,z,code,status FROM
                            (SELECT * FROM coord
                            WHERE id < {$id}
                            ORDER BY id DESC
                            LIMIT 2) as foo
                            ORDER BY id ASC;";
              $result_before = pg_query($db, $sql_before);

              $sql_before_status = "SELECT status FROM
                            (SELECT * FROM coord
                            WHERE id < {$id}
                            ORDER BY id DESC
                            LIMIT 2) as foo
                            ORDER BY id ASC;";
              $result_before_status = pg_query($db, $sql_before_status);

              $sql_after = "SELECT point,x,y,z,code,status FROM coord
                            WHERE id > {$id}
                            ORDER BY id ASC
                            LIMIT 2;";
              $result_after = pg_query($db, $sql_after);

              $sql_after_status = "SELECT status FROM coord
                            WHERE id > {$id}
                            ORDER BY id ASC
                            LIMIT 2;";
              $result_after_status = pg_query($db, $sql_after_status);
            
              // Mendapatkan jumlah kolom dalam hasil query
              $numFields = pg_num_fields($result);
            
              // Menampilkan nama kolom
              echo '<tr>';
              for ($i = 0; $i < $numFields; $i++) {
              $fieldName = pg_field_name($result, $i);
              echo "<th class = 'text-center'>" . $fieldName . "</th>";
                  }
              echo "<th class = 'text-center'> Status </th>";
              echo '<tr>';
            }else{
              $result_before = false;
              $result = false;
              $result_after = false;
            }
            ?>
      </thead>
      <tbody>
        <form action="update.php" method="post">
            <?php

              if($result_before){
                //Menampilkan data before
                $row = pg_fetch_all($result_before);
                $kolom = pg_fetch_all_columns($result_before);
                for ($a = 0; $a < count($kolom); $a++) {
                echo "<tr>";
                echo '<td class="text-center">' . $row[$a]['point'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['x'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['y'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['z'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['code'] . "</td>";
                $status = $row[$a]['status'];
                echo '<td class="text-center">' . '<h6><span class="badge bg-'. (($status == "plot") ? "success" : (($status == "skip") ? "warning" : "secondary")) .'">'. $status .'</span></h6>' . "</td>";
                // echo '<td class="text-center">' . '<button type="button" class="btn btn-' . (($status == "plot") ? "success" : (($status == "skip") ? "warning" : "secondary")) . ' btn-sm" disabled >'.$row[$a]['status'].'</button>' . "</td>";
                echo "</tr>";
                }
              }
              
              if($result){
                //Menampilkan data point
                while ($row = pg_fetch_row($result)) {
                  echo '<tr class="table-active">';
                  $status = pg_fetch_assoc($result_status)['status'];
                  for ($i = 0; $i < $numFields; $i++) {
                      echo '<td class="text-center">' . $row[$i] . "</td>";
                          }
                  echo '<input type="hidden" name="status" value="'. $status .'">';
                  echo '<input type="hidden" name="point" value="'. $_GET['point'] .'">';
                  echo '<td class="text-center"><button id="ganti" type="submit" class="btn btn-'. (($status == "plot") ? "success" : (($status == "skip") ? "warning" : "secondary")) . ' btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                  <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                  <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                </svg></button></td>';
                  echo "</tr>";
                }
              }
              
              if($result_after){
                //Menampilkan data after
                $row = pg_fetch_all($result_after);
                $kolom = pg_fetch_all_columns($result_after);
                for ($a = 0; $a < 2; $a++) {
                echo "<tr>";
                echo '<td class="text-center">' . $row[$a]['point'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['x'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['y'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['z'] . "</td>";
                echo '<td class="text-center">' . $row[$a]['code'] . "</td>";
                $status = $row[$a]['status'];
                echo '<td class="text-center">' . '<h6><span class="badge bg-'. (($status == "plot") ? "success" : (($status == "skip") ? "warning" : "secondary")) .'">'. $status .'</span></h6>' . "</td>";
                // echo '<td class="text-center">' . '<button type="button" class="btn btn-' . (($status == "plot") ? "success" : (($status == "skip") ? "warning" : "secondary")) . ' btn-sm" disabled >'.$row[$a]['status'].'</button>' . "</td>";
                echo "</tr>";
                }
              }
              ?>
          </form>
      </tbody>
    </table>
  </div>
  
    <!-- <div class="alert alert-success d-flex justify-content-center" role="alert">
      <div class="box-gambar">
        <?php
        $jml_x = floor($x_kertas/$grid_gambar);
        $jml_y = floor($y_kertas/$grid_gambar);
        for($i = 0; $i< $jml_x*$jml_y; $i++){
          echo '<div class="boxed kotakan">11</div>';
        }
        
        ?>
      </div>
    </div> -->
  
  
  </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
   <script src="script.js"></script>
   
</body>
</html>