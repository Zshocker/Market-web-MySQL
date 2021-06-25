<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if(isset($_GET['id']))
{   
    $id=$_GET['id'];
    $uti=$_SESSION['id_uti'];
    $scr="SELECT id_panier from utilisateur where id_uti=$uti";
    $res=$conn->query($scr);
    $res=$res->fetch_assoc();
    $id_pan=$res['id_panier'];
    $scr="DELETE FROM avoir_pan_pro where id_panier=$id_pan AND id_prod=$id";
   if(!$conn->query($scr))
   echo $conn->error;

}
CloseCon($conn);
header("Location: PanierPa.php", true, 301);
?>