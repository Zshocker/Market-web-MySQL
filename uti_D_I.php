<?php
require_once 'Emailer.php';
require_once 'ConnexionToBD.php';
$conn=Conect_ToBD("magasin_en_ligne","root");
if(isset($_POST['Delete']))
{
    $id_uti=$_POST['id_uti'];
    $scr="DELETE FROM utilisateur WHERE id_uti=$id_uti";
    $conn->query($scr);
    CloseCon($conn);
    header("Location: ListUti.php", true, 301);
}

CloseCon($conn);
?>