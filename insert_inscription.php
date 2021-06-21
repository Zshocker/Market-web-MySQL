<?php 
include_once 'ConnexionToBD.php';

if($_POST)
{
    $conn=Conect_ToBD("magasin_en_ligne","root");
    $Pnom=$_POST['Prenom'];
    $Nom=$_POST['Nom'];
    $Email=$_POST['Email'];
    $mdp=md5($_POST['mdp']);
    $tel=$_POST['tele'];
    $id_ville=intval($_POST['ville']);
    $addresse=$_POST['adresse'];
    $date=date("Y-m-d");
    $scr="INSERT INTO inscription(nomI,prenomI,emailI,adresseI,mdpI,tele,date_inscriI,id_ville) Values('$Nom','$Pnom','$Email','$addresse','$mdp','$tel','$date',$id_ville) ";
    if(!$conn->query($scr))echo $conn->error;
    CloseCon($conn);
}

?>