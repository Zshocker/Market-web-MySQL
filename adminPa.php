<?php
session_start();
?>

<html>

<head>
  <title>Select what To do</title>
  <link rel="StyleSheet" href="butonns.css">
  <link rel="stylesheet" href="styleForInscrip.css">
  <script src="JS Scripts/name.js"></script>
</head>

<body style="margin:0px;">
  <div class="bar">
    <div style="padding-top:15px ; height:100%;">
      <?php if (!isset($_SESSION['id_uti'])) {
        header("Location: index.php", true, 301);
      } elseif ($_SESSION['type_uti'] != 'admin') {
        header("Location: index.php", true, 301);
      } else {
      ?>
        <form method="POST" action="LogMeOut.php">
          <input type="submit" value="logout" name="Logout" class="mi" onclick="return confirm('Are you sure?');">
        </form>
      <?php
      }
      ?>
    </div>
  </div>
  <div class="cont-92-5">
    <div class="sidebar">
      <div class="sideBDiv"><button class="sideBut"  onclick="window.location.href='adminPa.php';">Ajouter des produits</button></div>
      <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='cat_G.php';">Gestion des categories</button></div>
      <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListProd.php';"> Afficher les produit</button></div>
      <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListInscri.php';">Afficher les inscription</button></div>   
    </div>
    <div class="MainCont">
    <center>
      <div class="container"> 
        <form action="produit.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-25">
              <label for="name">Prod name: </label>
            </div>
            <div class="col-75">
              <input type="text" id="name" name="prodName" required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="prix">prod prix: </label>
            </div>
            <div class="col-75">
              <input type="text" id="prix" name="prodPrix" required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="red"> prod reduction: </label>
            </div>
            <div class="col-75">
              <input type="text" id="red" name="prodRed" required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="Cat">prod Categorie:</label>
            </div>
            <div class="col-75">
              <select id="Cat" name="prodCat">
                <?php
                require_once 'ConnexionToBD.php';
                $conn = Conect_ToBD("magasin_en_ligne", "root");
                $resultE = $conn->query("Select * from categorie");
                while ($qe = $resultE->fetch_assoc()) {
                  $content = $qe['label_cat'];
                  $id = $qe['id_cat'];
                  echo "<option value=\"$id\"> $content </option>";
                }
                CloseCon($conn);
                ?>
              </select>
            </div>
          </div>
          <div class="Bigrow">
            <div class="col-25">
              <label for="Desc">prod Description :</label>
            </div>
            <div class="col-75">
              <textarea id="Desc" name="prodDescri" style="height:200px" maxlength="100" required></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="prodImage"> prod image: </label>
            </div>
            <div class="col-75">
              <input type="file" id="prodImage" name="prodImage[]" multiple="multiple" required>
            </div>
          </div>
          <div class="row">
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
    </center>
    </div>
  </div>
</body>

</html>