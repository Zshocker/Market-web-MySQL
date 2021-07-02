<?php 
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if(isset($_POST['ButnAj']))
{
    $id_pro=$_POST['id_prod'];
    $qte=$_POST['qte'];
    $id_ut=$_SESSION['id_uti'];
    $scr="SELECT id_panier from utilisateur where id_uti=$id_ut";
    $id_pan=$conn->query($scr);
    $id_pan=$id_pan->fetch_assoc();
    $id_pan=$id_pan['id_panier'];
    $select="SELECT qte from avoir_pan_pro where id_panier=$id_pan and id_prod=$id_pro";
    $resu=$conn->query($select);
    $resu=$resu->fetch_assoc();
    if(!empty($resu))
    {
        $qtei=$resu['qte'];
        $qte+=$qtei;
        $scr="UPDATE avoir_pan_pro SET qte=$qte where id_panier=$id_pan and id_prod=$id_pro ";
    }
    else{
    $scr="INSERT into avoir_pan_pro(id_panier,id_prod,qte) values($id_pan,$id_pro,$qte)";
    }
    if(!$conn->query($scr))
    echo $conn->error;
}

CloseCon($conn);
header("Location: PanierPa.php",true,301);



?>