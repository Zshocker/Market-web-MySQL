<?php
require_once 'ConnexionToBD.php';
$conn=Conect_ToBD("magasin_en_ligne","root");
if(isset($_POST['Delete']))
{
    $id_Prod=$_POST['id_prod'];
    $scr="DELETE FROM produit WHERE id_prod=$id_Prod";
    $scr_photos="DELETE FROM photo WHERE id_prod=$id_Prod";
    $sele="SELECT photo From photo where id_prod=$id_Prod";
    $res=$conn->query($sele);
    while($qe=$res->fetch_assoc())
    {
        $qe=$qe['photo'];
        unlink($qe);
    }
    $conn->query($scr_photos);
    $conn->query($scr);
    header("Location: listdesProd.php", true, 301);
}
CloseCon($conn);
?>