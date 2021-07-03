<?php
require_once 'ConnexionToBD.php';
if($_POST)
{
    $conn=Conect_ToBD("magasin_en_ligne","root");
    $id_prod=$_POST['id_prod'];
    $qte=$_POST['QteAch'];
    $prix=$_POST['prixAch'];
    $forn=$_POST['fornis'];
    $scr="INSERT INTO achat_prod(id_prod,id_forn,qte_achat,prix_unite) VALUES ($id_prod,$forn,$qte,$prix)";
    $conn->query($scr);
    CloseCon($conn);
}
header("Location:adminPa.php ",true,301);
?>