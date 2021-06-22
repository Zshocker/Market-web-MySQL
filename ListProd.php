<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
$scr = "SELECT id_prod,Designation,Description,prix_std,reduction,label_cat,id_cat FROM produit NATURAL JOIN categorie ORDER BY id_prod ";
$result = $conn->query($scr);
?>

<html>

<head>
    <title>Les produits</title>
    <script src="JS Scripts/name.js"></script>
    <link rel="StyleSheet" href="styleForInscrip.css">
    <link rel="StyleSheet" href="tableStyle.css">
    <link rel="StyleSheet" href="prods.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function insert_value_prod(PName, PPrix, PRed, PCat, Pdesc) {
            document.getElementById('name').value = PName;
            document.getElementById('prix').value = PPrix;
            document.getElementById('red').value = PRed;
            document.getElementById('Cat').value = PCat;
            document.getElementById('Desc').value = Pdesc;
        }
    </script>
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

        <div class="table-wrapper">
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
                        $sc_photo = "SELECT MIN(id_photo),photo FROM photo where id_prod=$id_prod";
                        $rs = $conn->query($sc_photo);
                        $rs = $rs->fetch_assoc();
                        $imag = $rs['photo'];
                        $name = $qe['Designation'];
                        $desc = $qe['Description'];
                        $prix = $qe['prix_std'];
                        $red = floatval($qe['reduction']);
                        $redP = $red * 100;
                        $cat = $qe['label_cat'];
                        $id_cat = $qe['id_cat'];



                    ?>
                        <tr>
                            <td><img src="<?php echo $imag; ?>" style="width:50px;height:50px;"></td>
                            <td><?php echo "$name" ?></td>
                            <td><?php echo "$prix" ?></td>
                            <td><?php echo "$redP" ?></td>
                            <td><?php echo "$desc" ?></td>
                            <td><?php echo "$cat" ?></td>
                            <td>
                                <form method="POST" action="prod_D.php">
                                    <input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>">
                                    <button class="miniBut" style="background-color: red;" name="Delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></button>
                                    <button type="button" class="miniBut" style="background-color:aqua; margin-left: 5px;" onclick="add_hidden_value_id('FormUp',<?php echo $id_prod; ?>,'id_prod');insert_value_prod(<?php echo "'$name',$prix ,$red ,$id_cat ,'" . str_replace(PHP_EOL, ' ', $desc) . " ' ";  ?>);show_elem_id('Updater'); "><i class="fa fa-edit"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                <tbody>
            </table>
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
                            <label for="prodImage">Ajouter des images: </label>
                        </div>
                        <div class="col-75">
                            <input type="file" id="prodImage" name="prodImage[]" multiple="multiple">
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" name="Submit" value="Update" onclick="return confirm('Are you sure?');">
                    </div>
                </form>
            </div>
        </center>
    </div>



</body>

</html>