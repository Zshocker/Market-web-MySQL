<html>

<head>
  <title>Inscipt</title>
  <link rel="StyleSheet" href="styleForInscrip.css">
  <link rel="StyleSheet" href="prods.css">
  <script src="JS Scripts/name.js"></script>
</head>

<body style="margin:0px;">
  <div class="bar">
    <div style="padding-top:15px ; height:100%;">
      <button class="mi" onclick="show_elem_id('inscrip')">Sign Up</button>
      <button class="mi" onclick="show_elem_id('Login')" style="margin-Right: 5px;">Log In</button>
    </div>
  </div>
  <div>
    <?php
    require_once 'ConnexionToBD.php';
    $conn = Conect_ToBD("magasin_en_ligne", "root");
    $scr = "SELECT id_prod,Designation,prix_std,reduction FROM produit ORDER BY id_prod ";
    $result = $conn->query($scr);

    while ($qe = $result->fetch_assoc()) {
      $id_prod = $qe['id_prod'];
      $sc_photo = "SELECT MIN(id_photo),photo FROM photo where id_prod=$id_prod";
      $rs = $conn->query($sc_photo);
      $rs = $rs->fetch_assoc();
      $imag = $rs['photo'];
      $name = $qe['Designation'];
      $prix = $qe['prix_std'];
      $red = floatval($qe['reduction']);
      $red = $red * 100;
    ?>
      <div class="boxProd">
        <div class="ProdImageDiv">
          <a href="ProdInfo.php?id=<?php echo $id_prod;  ?>">
            <center><img src="<?php echo $imag; ?>" style="width:200px;height:200px; border-radius:10px;"></center>
          </a>
        </div>
        <div class="ProdInfoDiv">
          <div style="margin: 5px;">
            <center><a class="Prod_name" href="ProdInfo.php?id=<?php echo $id_prod;  ?>"><span> <?php echo $name;  ?></span></a></center>
          </div>
          <div style="margin-top: 25px; margin-left: 5px; margin-right:5px;">
            <span style="font-weight:bold; margin:5px; float:left;"><?php echo $prix;  ?>DH</span>
            <span style="font-weight:bold; margin:5px; float:right;"><?php echo $red;  ?>%</span>
          </div>
        </div>


      </div>

    <?php
    }
    ?>
  </div>


  <div class="modal" id="inscrip">
    <center>
      <div class="container">
        <div class="row">
          <button class="mi" onclick="unshow_elem_id('inscrip')">&times;</button>
        </div>
        <form action="action_page.php" method="POST">
          <div class="row">
            <div class="col-25">
              <label for="fname">Prenom: </label>
            </div>
            <div class="col-75">
              <input type="text" id="fname" name="Prenom" placeholder="Votre prenom.." required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="lname">Nom: </label>
            </div>
            <div class="col-75">
              <input type="text" id="lname" name="Nom" placeholder="votre Nom.." required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="Email">Email: </label>
            </div>
            <div class="col-75">
              <input type="text" id="Email" name="Email" placeholder="votre Email.." required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="mdp">Mot de passe: </label>
            </div>
            <div class="col-75">
              <input type="password" id="mdp" name="mdp" placeholder="Creer un mdp.." required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="tele">Telephone: </label>
            </div>
            <div class="col-75">
              <input type="text" id="tele" name="tele" placeholder="votre Tel..">
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="ville">Ville:</label>
            </div>
            <div class="col-75">
              <select id="ville" name="ville">
                <?php
                $result = $conn->query("Select * from ville");
                while ($qe = $result->fetch_assoc()) {
                  $content = $qe['ville'];
                  $id = $qe['id_ville'];
                  echo "<option value=\"$id\"> $content </option>";
                }
                CloseCon($conn);
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="adresse">Adresse</label>
            </div>
            <div class="col-75">
              <textarea id="adresse" name="adresse" placeholder="Write something.." style="height:200px" maxlength="100" required></textarea>
            </div>
          </div>
          <div class="row">
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
    </center>
  </div>
  <div class="modal" id="Login">
    <center>
      <div class="container">
        <div class="row">
          <button class="mi" onclick="unshow_elem_id('Login')">&times;</button>
        </div>
        <form action="LoginChek.php" method="POST">
          <div class="row">
            <div class="col-25">
              <label for="Log">Login: </label>
            </div>
            <div class="col-75">
              <input type="text" id="log" name="Login" placeholder="Votre Login.." required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="md">Mot de passe: </label>
            </div>
            <div class="col-75">
              <input type="password" id="md" name="mdp" placeholder="votre mot de passe.." required>
            </div>
            <div class="row">
              <input type="submit" value="Log In">
            </div>
        </form>
      </div>
    </center>
  </div>
</body>

</html>