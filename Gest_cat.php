<?php 
require_once 'ConnexionToBD.php';
$conn=Conect_ToBD("magasin_en_ligne","root");
if(isset($_POST['Ajouter']))
{
    $NCat=$_POST['NewCat'];
    $scr="INSERT INTO categorie(label_cat) VALUES ('$NCat')";
    $conn->query($scr);
}
elseif(isset($_POST['Supp']))
{
    $id=$_POST['prodCat'];
    $scr="DELETE FROM produit where id_cat=$id";
    $scrr="DELETE FROM categorie where id_cat=$id";
    $SCR_CAT="SELECT id_prod From produit where id_cat=$id";
    $res=$conn->query($SCR_CAT);
    while($result=$res->fetch_assoc())
    {   
        $qe=$result['id_prod'];
        $sele="SELECT photo From photo where id_prod=$qe";
        $res1=$conn->query($sele);
        while($qer=$res1->fetch_assoc())
        {
        $qer=$qer['photo'];
        unlink($qer);
        }
        $str="DELETE FROM photo where id_prod=$qe";
        $conn->query($str);
    }
    $conn->query($scr);
    $conn->query($scrr);
}
elseif(isset($_POST['Modifier']))
{
    $id=$_POST['prodCat'];
    $nn=$_POST['CatMod'];
    $scr="UPDATE categorie SET label_cat='$nn' where id_cat=$id";
    $conn->query($scr);
}
CloseCon($conn);
header("Location: adminPa.php", true, 301);
?>