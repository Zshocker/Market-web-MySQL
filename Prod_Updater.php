<?php 
require_once 'ConnexionToBD.php';

if($_POST)
{
    $conn=Conect_ToBD("magasin_en_ligne","root");
    $id_prod=$_POST['id_prod'];
    $name=$_POST['prodName'];
    $Desc=$_POST['prodDescri'];
    $prix=floatval($_POST['prodPrix']);
    $red=floatval($_POST['prodRed']);
    $id_cat=intval($_POST['prodCat']); 
    $scr="UPDATE produit SET Designation='$name',Description='$Desc',prix_std=$prix,reduction=$red,id_cat=$id_cat where id_prod=$id_prod";
    $conn->query($scr);
    $id_photo_scr="SELECT MAX(id_photo) as id from photo";
    $id_photo=$conn->query($id_photo_scr);
    $id_photo=$id_photo->fetch_assoc();
    $id_photo=intval($id_photo['id']);
    $id_photo++;
    $numofPhotos=count($_FILES["prodImage"]["name"]);
    for ($i=0; $i < $numofPhotos; $i++) 
    { 
        $target="uploadedImages\imgfor $name  $id_photo.jpeg";
        move_uploaded_file($_FILES["prodImage"]["tmp_name"][$i],$target);
        $target="uploadedImages\\\\imgfor $name  $id_photo.jpeg";
        $inser_img_scr="INSERT INTO photo (photo,id_prod) Values('$target',$id_prod)";
        $conn->query($inser_img_scr);   
        $id_photo++;
    }
    CloseCon($conn);
    header("Location: listProd.php", true, 301);
}

?>