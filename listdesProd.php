<!DOCTYPE html>
<html>

<head>
    <title>Les produits</title>
    <script src="JS Scripts/name.js"></script>
    
    <link rel="StyleSheet" href="styleForInscrip.css">
</head>

<body>
    <script>
        function insert_value_prod(PName, PPrix, PRed, PCat, Pdesc) {
            document.getElementById('name').value = PName;
            document.getElementById('prix').value = PPrix;
            document.getElementById('red').value = PRed;
            document.getElementById('Cat').value = PCat;
            document.getElementById('Desc').value = Pdesc;
        }
    </script>
    <?php
    require_once 'ConnexionToBD.php';
    $conn = Conect_ToBD("magasin_en_ligne", "root");
    $scr = "SELECT id_prod,Designation,Description,prix_std,reduction,label_cat,id_cat FROM produit NATURAL JOIN categorie ORDER BY id_prod ";
    $result = $conn->query($scr);

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
        $id_cat=$qe['id_cat'];
    ?>
        <div class="row" style="background-color: cyan; margin-top: 5px;">
            <div class="col-25">
                <img src="<?php echo $imag; ?>" style="width:200px;height:200px; margin-left: 25px;">
            </div>
            <div class="col-75">
                <?php echo "$name --- $desc --- $prix dh --- $redP % --- $cat"; ?>
                <form method="POST" action="prod_D.php">
                    <input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>">
                    <input type="submit" value="Delete" name="Delete"/>
                </form>
                <button type="button" class="mi" style="margin-right: 5px;" onclick="add_hidden_value_id('FormUp',<?php echo $id_prod; ?>,'id_prod');insert_value_prod(<?php echo "'$name',$prix ,$red ,$id_cat ,'$desc' ";  ?>);show_elem_id('Updater'); ">Update</button>
            </div>
        </div>
    <?php   
    }
    ?>
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
                                while ($qe = $resultE->fetch_assoc()) 
                                {
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
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </center>
    </div>





</body>

</html>