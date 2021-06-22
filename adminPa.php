<html>

<head>
  <title>Select what To do</title>
  <link rel="StyleSheet" href="butonns.css">
  <link rel="stylesheet" href="styleForInscrip.css">
  <script src="JS Scripts/name.js"></script>
</head>

<body>
  <button class="cybr-btn" onclick="show_elem_id('ProdAj')">
    Ajouter des produit<span aria-hidden>_</span>
    <span aria-hidden class="cybr-btn__glitch">Ajouter des produit</span>
    <span aria-hidden class="cybr-btn__tag">RW</span>
  </button><br><br>
  <button class="cybr-btn" onclick="show_elem_id('GestCat')">
    Gestion des categorie<span aria-hidden>_</span>
    <span aria-hidden class="cybr-btn__glitch">Gestion des categorie</span>
    <span aria-hidden class="cybr-btn__tag">RW</span>
  </button><br><br>
  <button class="cybr-btn" onclick="window.location.href='ListProd.php';">
    Afficher les produit<span aria-hidden>_</span>
    <span aria-hidden class="cybr-btn__glitch">Afficher les produit</span>
    <span aria-hidden class="cybr-btn__tag">RW</span>
  </button>
  <div class="modal" id='ProdAj'>
    <center>
      <div class="container">
        <div class="row">
          <button class="mi" onclick="unshow_elem_id('ProdAj')">&times;</button>
        </div>
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
          <div class="row">
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
  <div class="modal" id="GestCat">
    <center>
      <div class="container">
        <div class="row">
          <button class="mi" onclick="unshow_elem_id('Mod'); unshow_elem_id('GestCat');">&times;</button>
        </div>
        <form action="Gest_cat.php" method="POST">
          <div class="row">
            <div class="col-25">
              <label for="catnew">New cat : </label>
            </div>
            <div class="col-75">
              <input type="text" id="catnew" name="NewCat">
              <input type="submit" name='Ajouter' value="Ajouter">
            </div>
            <div class="row">
              <div class="col-25">
                <label for="Cat">Si vous voulez modifier ou Supprimer une categorie:</label>
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
                <input type="submit" name='Supp' value="Supprimer" onclick="return confirm('Cette action va supprimer tous les produits de cette categorie');">
                <button type="button" class="mi" onclick="show_elem_id('Mod');" style="margin-right: 5px;">Modifier</button>
              </div>
            </div>
            <div class="row" id="Mod" style="display: none;">
              <div class="col-25">
                <label for="catnew">Categorie : </label>
              </div>
              <div class="col-75">
                <input type="text" id="catMod" name="CatMod" placeholder="Si vous voulez modifier une categorie....">
                <input type="submit" name='Modifier' value="Modifier">
              </div>
        </form>
      </div>
    </center>

  </div>
</body>

</html>