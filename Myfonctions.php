<?php
require_once "ConnexionToBD.php";
function Get_qte($id_prod)
{
$conn = Conect_ToBD("magasin_en_ligne", "root");
$scr="SELECT SUM(quantite) from ligne_commande where id_prod=$id_prod";
$scr2="SELECT SUM(qte_achat) from achat_prod where id_prod=$id_prod";
$res=$conn->query($scr);
$res=$res->fetch_all();
$qteCom=$res[0][0];
$res=$conn->query($scr2);
echo $conn->error;
$res=$res->fetch_all();
$qteAch=$res[0][0];
$qte_stock=$qteAch-$qteCom;
CloseCon($conn);
return $qte_stock;
}
?>