<?php
require_once 'ConnexionToBD.php';
require_once 'Emailer.php';

if($_POST)
{
    $conn=Conect_ToBD("magasin_en_ligne","root");
    $nomu=$_POST['nom'];
    $prenomu=$_POST['prenom'];
    $emailu=$_POST['email'];
    $adresseu=$_POST['adresse'];
    $mdpu=md5($_POST['mdp']); 
    $teleu=$_POST['tele'];
    $teleu=$_POST['tele'];
    $id_typeu=intval($_POST['type']);
    $date=date("Y-m-d");
    $id_ville=intval($_POST['ville']);

    do 
    {
        $login = $nomu."_".$prenomu."_".random_int(1,3000);
        $scr = "SELECT login FROM utilisateur where login='$login'";
        $res = $conn->query($scr);
        $qe = $res->fetch_assoc(); 

    }while(!empty($qe['login']));




    $scr="INSERT INTO utilisateur (nom,prenom,email,adresse,login,mdp,tele,date_inscris,id_type,id_ville) Values('$nomu','$prenomu','$emailu','$adresseu','$login','$mdpu',$teleu,'$date',$id_typeu,$id_ville)";
    
    if(!$conn->query($scr))
    {
        echo $conn->error;
    }
    else
    {
    
    
    Send_Login_to($emailu,$login);
    header("Location: ListUti.php", true, 301);
    }
    
    CloseCon($conn);
    header("Location: ListUti.php", true, 301);
}



?>