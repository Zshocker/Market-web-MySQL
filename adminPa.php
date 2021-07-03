<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $scr = "SELECT id_prod,Designation,Description,prix_std,reduction,label_cat,id_cat,prix_barre FROM produit NATURAL JOIN categorie WHERE Designation LIKE '%$search%' ORDER BY id_prod ";
} else $scr = "SELECT id_prod,Designation,Description,prix_std,reduction,label_cat,id_cat,prix_barre FROM produit NATURAL JOIN categorie ORDER BY id_prod ";
$result = $conn->query($scr);
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Les produits</title>
    <script src="JS Scripts/name.js"></script>
    <link rel="StyleSheet" href="styleForInscrip.css">
    <link rel="StyleSheet" href="tableStyle.css">
    <link rel="StyleSheet" href="prods.css">
    <link rel="stylesheet" href="CssFontA/css/all.css">

</head>

<body style="margin:0px;">
    <div class="bar">
        <div style=" height:100%;">
            <a href="index.php"><img src="rw-markets.png" style="width:auto; height:75%; margin-left:25px;"></a>
            <?php if (!isset($_SESSION['id_uti'])) {
                header("Location: index.php", true, 301);
            } elseif ($_SESSION['type_uti'] != 'admin') {
                header("Location: index.php", true, 301);
            } else {
            ?>
                <form method="POST" action="LogMeOut.php" style="float:right; margin:0px">
                    <input type="submit" value="logout" name="Logout" class="mi" onclick="return confirm('Are you sure?');">
                </form>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="cont-92-5">
        <div class="sidebar">
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ClientPa.php';">Consulter les produits</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='PanierPa.php';">Afficher Mon panier</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='CommandePa.php';">Afficher Mes Commandes</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='adminPa.php';">Gestion des produits</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListInscri.php';">Afficher les inscription</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListUti.php';">Afficher les utilisateurs</button></div>
        </div>
        <div class="MainCont">
            <div class="navBar">
                <input type="text" name="search" class="searchBar" id="searcher" placeholder="Search">
                <button type="submit" class="miniBut" onclick="window.location.href='adminPa.php?search='+Get_Search('searcher');" style="margin-top:8px; width: 30px; height: 32px;"><i class="fa fa-search"></i></button>
                <button class="mi" onclick="show_elem_id('ProdAj')" style="background-color:#1ebb2b;"><i class="fa fa-plus" aria-hidden="true"></i>&emsp;Ajouter des produits</button>
                <button class="mi" onclick="show_elem_id('GestCat')" style="background-color:#1ebb2b;">Gestion des categories</button>
            </div>
            <div class="table-wrapper">
                <center>
                    <table class="fl-table">
                        <thead>
                            <tr>
                                <th>image</th>
                                <th>Nom</th>
                                <th>prix</th>
                                <th>reduction</th>
                                <th>description</th>
                                <th>categorie</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($qe = $result->fetch_assoc()) {
                                $id_prod = $qe['id_prod'];
                                $sc_photo = "SELECT id_photo,photo FROM photo where id_prod=$id_prod";
                                $rs = $conn->query($sc_photo);
                                $rs = $rs->fetch_all(MYSQLI_ASSOC);
                                $imag = $rs[0]['photo'];
                                $name = $qe['Designation'];
                                $desc = $qe['Description'];
                                $prix = $qe['prix_std'];
                                $red = floatval($qe['reduction']);
                                $redP = $red * 100;
                                $cat = $qe['label_cat'];
                                $id_cat = $qe['id_cat'];
                                $prixF = $qe['prix_barre'];


                            ?>
                                <tr>
                                    <td><img src="<?php echo $imag; ?>" style="width:50px;height:50px;"></td>
                                    <td><?php echo "$name" ?></td>
                                    <td><?php echo "$prix" ?></td>
                                    <td><?php echo "$redP" ?>%</td>
                                    <td><?php echo "$desc" ?></td>
                                    <td><?php echo "$cat" ?></td>
                                    <td>
                                        <form method="POST" action="prod_D.php">
                                            <input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>">
                                            <button class="miniBut" style="background-color: red;" name="Delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></button>
                                            <button type="button" class="miniBut" style="background-color:aqua; margin-left: 5px;" onclick="add_hidden_value_id('FormUp',<?php echo $id_prod; ?>,'id_prod');insert_value_prod(<?php echo "'$name',$red ,$id_cat ,'" . str_replace(PHP_EOL, ' ', $desc) . "','$prixF'  ";  ?>); delete_All_other_images(); <?php
                                                                                                                                                                                                                                                                                                                                                        foreach ($rs as $img) {
                                                                                                                                                                                                                                                                                                                                                            $id = $img['id_photo'];
                                                                                                                                                                                                                                                                                                                                                            $image = $img['photo'];
                                                                                                                                                                                                                                                                                                                                                        ?>
                                                add_images_ToMod(<?= $id ?>,'<?= str_replace('\\', '\\\\', $image) ?>');
                                            <?php
                                                                                                                                                                                                                                                                                                                                                        }
                                            ?> show_elem_id('Updater'); "><i class="far fa-edit"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <tbody>
                    </table>
                </center>
            </div>
        </div>
    </div>
    <div class="modal" id="Updater">
        <center>
            <div class="container">
                <div class="row">
                    <button class="mi" onclick=" remove_html_by_id('id_prod');unshow_elem_id('Updater');">&times;</button>
                </div>
                <form action="Prod_Updater.php" id="FormUp" method="POST" enctype="multipart/form-data">
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
                                $resultE = $conn->query("Select * from categorie");
                                while ($qe = $resultE->fetch_assoc()) {
                                    $content = $qe['label_cat'];
                                    $id = $qe['id_cat'];
                                    echo "<option value=\"$id\"> $content </option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="prix">Prix barre: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="prixF" name="fake_prix">
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
                            <label for="prodImage">Ajouter des images: </label>
                        </div>
                        <label>
                            <div class="col-75" style="height:100px;">
                                <input type="file" id="prodImage" name="prodImage[]" multiple="multiple" style="height:100px;">
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="prodImage">Selectione les image a supprimer: </label>
                        </div>
                        <div class="col-75" style="height:100px;" id="WhereImagesGo">

                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" name="Submit" value="Update" onclick="return confirm('Are you sure?');">
                    </div>
                </form>
            </div>
        </center>
    </div>
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
                            <input type="text" id="nameA" name="prodName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="prix">prod prix: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="prixA" name="prodPrix" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="prix">Prix barré: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="prixFA" name="fake_prix">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="red"> prod reduction: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="redA" name="prodRed" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="Cat">prod Categorie:</label>
                        </div>
                        <div class="col-75">
                            <select id="CatA" name="prodCat">
                                <?php

                                $resultE = $conn->query("Select * from categorie");
                                while ($qe = $resultE->fetch_assoc()) {
                                    $content = $qe['label_cat'];
                                    $id = $qe['id_cat'];
                                    echo "<option value=\"$id\"> $content </option>";
                                }

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
                            <label for="prodImage"> prod images: </label>
                        </div>
                        <label>
                            <div class="col-75" style="height:100px;">
                                <input type="file" id="prodImageA" name="prodImage[]" multiple="multiple" style="height:100px;" required>
                            </div>
                        </label>
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
                            <input type="submit" id="catnewBut" name='Ajouter' value="Ajouter">
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="Cat">Si vous voulez modifier ou Supprimer une categorie:</label>
                            </div>
                            <div class="col-75">
                                <select id="CatSelect" name="prodCat">
                                <option></option>
                                    <?php
                                    $resultE = $conn->query("Select * from categorie");
                                    while ($qe = $resultE->fetch_assoc()) {
                                        $content = $qe['label_cat'];
                                        $id = $qe['id_cat'];
                                        echo "<option value=\"$id\"> $content </option>";
                                    }
                                    CloseCon($conn);
                                    ?>
                                </select>
                                <input type="submit" name='Supp' value="Supprimer" id="SuppCat" onclick="return confirm('Cette action va supprimer tous les produits de cette categorie');">
                                <button type="button" class="mi" id="ModfiBut" onclick="unshow_elem_id('ModfiBut');  show_elem_id('Mod');" style="margin-right: 5px;">Modifier</button>
                            </div>
                        </div>
                        <div class="row" id="Mod" style="display: none;">
                            <div class="col-25">
                                <label for="catnew">Categorie : </label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="catMod" name="CatMod" placeholder="Si vous voulez modifier une categorie....">
                                <input type="submit" id="ModiferButFinnale" name='Modifier' value="Modifier">
                            </div>
                </form>
            </div>
        </center>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function insert_value_prod(PName, PRed, PCat, Pdesc, PprixF) {
            document.getElementById('name').value = PName;
            document.getElementById('red').value = PRed;
            document.getElementById('Cat').value = PCat;
            document.getElementById('Desc').value = Pdesc;
            if (PprixF != "") document.getElementById('prixF').value = PprixF;
        }

        function Get_Search(str) {
            return document.getElementById(str).value;
        }

        function add_images_ToMod(idphot, scr) {
            document.getElementById('WhereImagesGo').innerHTML += ' <div class="MiniImageCont"><label><input type="checkbox" name="ImagesToDelete[]" value="' + idphot + '" style="position:absolute;">   <img src="' + scr + '" class="miniImge"><label></div>  ';
        }

        function delete_All_other_images() {
            var MyImages = document.getElementById('WhereImagesGo').getElementsByClassName('MiniImageCont');
            for (let i = 0; i < MyImages.length; i++) {
                MyImages[i].remove();
            }
        }
        $("#catnew").keyup(function(){
            if(this.value!="")
            {
                $("#CatSelect").attr("disabled","disabled");
                $("#SuppCat").attr("disabled","disabled");
                $("#ModfiBut").attr("disabled","disabled");    
                $('#ModiferButFinnale').attr("disabled","disabled");
                $("#catMod").attr("disabled","disabled");
            }
            else{
                $("#CatSelect").removeAttr("disabled");
                $("#SuppCat").removeAttr("disabled");
                $("#ModfiBut").removeAttr("disabled");    
                $('#ModiferButFinnale').removeAttr("disabled");
                $("#catMod").removeAttr("disabled");
            }
        });
        $("#CatSelect").change(function()
        {
            if(this.value!="")
            {
                $("#catnew").attr("disabled","disabled");
                $("#catnewBut").attr("disabled","disabled");
            }else{
                $("#catnew").removeAttr("disabled");
                $("#catnewBut").removeAttr("disabled");
            }   
        });
        $("#catnewBut").click(function(){
            if($("#catnew").val()=="")
            {
                return false;
            }
            return true;
        })
        $("#ModiferButFinnale").click(function(){
            if($("#catMod").val()=="")
            {
                return false;
            }
            return true;
        })
    </script>

</body>

</html>