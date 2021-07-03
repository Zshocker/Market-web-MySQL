<?php
session_start();

function getRed($id,$conn2)
{
    $scr="SELECT reduction from produit where id_prod=$id";
    $res=$conn2->query($scr);
    $red=$res->fetch_assoc();
    return $red['reduction'];
}
function getQtePanier($id,$conn2,$id_pan)
{

    $scr="SELECT qte from avoir_pan_pro where id_prod=$id and id_panier=$id_pan";
    $res=$conn2->query($scr);
    $red=$res->fetch_assoc();
    return $red['qte'];
}

var_dump($_POST);
require_once 'ConnexionToBD.php';
if(isset($_POST['Confirm']))
{   
    $id_uti=$_SESSION['id_uti'];
    $conn=Conect_ToBD("magasin_en_ligne","root");
    $tab_Prod=$_POST['ProdIds'];
    $tab_Qte=$_POST['qteP'];
    $type_paiment=intval($_POST["type_Paiment"]);
    $address_liv=$_POST["adresse"];
    $date_com=date("Y-m-d");
    $scr="INSERT INTO commande(date_com,adresse_liv,id_etat,id_uti) values('$date_com','$address_liv',1,$id_uti)";
    $conn->query($scr);
    $id_Comm=$conn->insert_id;
    if($type_paiment==1)
    {
        $type_cart=$_POST["type-Carte"];
        $scr="INSERT INTO paiement_carte(id_typecarte,id_commande) Values($type_cart,$id_Comm)";
        $conn->query($scr);
        $id_pai=$conn->insert_id;
        $scr="UPDATE commande SET id_paiementCa=$id_pai where id_commande=$id_Comm ";
        $conn->query($scr);
    }
    elseif($type_paiment==2)
    {
        $scr="INSERT INTO paiement_espece(id_commande) Values($id_Comm)";
        $conn->query($scr);
        $id_pai=$conn->insert_id;
        $scr="UPDATE commande SET id_paiementE=$id_pai where id_commande=$id_Comm ";
        $conn->query($scr);
    }
    $scr="SELECT id_panier from utilisateur where id_uti=$id_uti";
    $id_pan=$conn->query($scr);
    $id_pan=$id_pan->fetch_assoc();
    $id_pan=$id_pan['id_panier'];
    for ($i=0; $i < count($tab_Prod); $i++) 
    { 
        $id_prod=$tab_Prod[$i];
        $qte=$tab_Qte[$i];
        $red=getRed($id_prod,$conn);
        $scr="INSERT INTO ligne_commande(reduction_ins,quantite,id_commande,id_prod) VALUES($red,$qte,$id_Comm,$id_prod)";
        $conn->query($scr);
        if(!isset($_POST['Not_pan'])){
        $qte_pan=getQtePanier($id_prod,$conn,$id_pan);
        if($qte_pan<=$qte)
        {
            $scr="DELETE FROM avoir_pan_pro where id_panier=$id_pan AND id_prod=$id_prod";
            $conn->query($scr);
        }
        else
        {
            $qte=$qte_pan-$qte;
            $scr="UPDATE avoir_pan_pro SET qte=$qte where id_panier=$id_pan and id_prod=$id_prod";
            $conn->query($scr);
        }
    }
    }
CloseCon($conn);
}
header("location: CommandePa.php",true,301);
?>