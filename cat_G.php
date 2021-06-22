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
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='adminPa.php';">Ajouter des produits</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='cat_G.php';">Gestion des categories</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListProd.php';"> Afficher les produit</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListInscri.php';">Afficher les inscription</button></div>
        </div>
        <div class="MainCont">
            <center>

                <form action="Gest_cat.php" method="POST">
                    <div class="container">
                        <div class="row">
                            <div class="col-25">
                                <label for="catnew">New cat : </label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="catnew" name="NewCat">
                                <input type="submit" name='Ajouter' value="Ajouter">
                            </div>
                        </div>
                        <div class="row" style="height: 100px;">
                            <div class="col-25">
                                <label for="Cat"> modifier ou Supprimer une categorie:</label>
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
                        </div>
                    </div>
                </form>

            </center>
        </div>
    </div>


























</body>

</html>