<!DOCTYPE html>
<html>

<head>
    <title>Les produits</title>
    <link rel="StyleSheet" href="styleForInscrip.css">
    <link rel="StyleSheet" href="prods.css">
</head>

<body>
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
</body>

</html>