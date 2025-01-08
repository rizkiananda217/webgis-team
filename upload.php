<?php
  $long = $_GET['long'];
  $lang = $_GET['lang'];
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="leaflet/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style2.css" />

    <title>Tambah Marker</title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <div class="section">


    <div class="container">
      <center><h2>Set Marker</h2></center>
    <div class="form-section">

    <form method="post" action="insert.php">
      <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label for="masukkanLong">Longitude </label>
            <input type="text" name="long" class="form-control" id="masukkanNama" placeholder="Masukkan Longitude" value="<?php echo $long ?> "/><br>
        </div>
      </div>
        <div class="col-6">
        <div class="form-group">
            <label for="masukkanLat">Latitude</label>
            <input type="text" name="lang" class="form-control" id="masukkanEmail" placeholder="Masukkan Latitude" value="<?php echo $lang ?> "/>
        </div>
      </div>
        <div class="col-12">
        <div class="form-group">
            <label for="masukkanEmail">Judul Marker</label>
            <input type="text" name="judul" class="form-control" id="masukkanEmail" placeholder="Masukkan Judul"/>
        </div>
      </div>
      <br>
        <button style="margin-left : 20px" class="btn btn-primary btn-pos" data-toggle="collapse" type="submit" value="simpan">SIMPAN</button>
    </form>
  </div>
    </div>
  </div>
  </div>
  <?php include 'footer.php'; ?>
  </body>

</html>
