<?php
require_once 'Emailer.php';
require_once 'ConnexionToBD.php';
$conn=Conect_ToBD("magasin_en_ligne","root");
if(isset($_POST['Delete']))
{
    $id_inscri=$_POST['id_inscri'];
    $scr="DELETE FROM inscription WHERE id_inscri=$id_inscri";
    $conn->query($scr);
    CloseCon($conn);
    header("Location: ListInscri.php", true, 301);
}
elseif(isset($_POST['accept']))
{
    $id_inscri =$_POST['id_inscri'];
    $scr = "SELECT nomI,prenomI,emailI,adresseI,mdpI,teleI,date_inscriI,id_ville FROM inscription NATURAL JOIN ville where id_inscri=$id_inscri ";
    $result = $conn->query($scr);
    $qe = $result->fetch_assoc();
    $name =$qe['nomI'];
    $prenom = $qe['prenomI'];
    $email = $qe['emailI'];
    $adresse = $qe['adresseI'];
    $mdp = $qe['mdpI'];
    $tele = $qe['teleI'];
    $date=date("Y-m-d");
    $ville = $qe['id_ville'];
    do 
    {
        $login = $name."_".$prenom."_".random_int(1,3000);
        $scr = "SELECT login FROM utilisateur where login='$login'";
        $res = $conn->query($scr);
        $qe = $res->fetch_assoc(); 

    }while(!empty($qe['login']));

    $scr1= "INSERT INTO utilisateur(nom,prenom,email,adresse,login,mdp,tele,date_inscris,id_type,id_ville) VALUES('$name','$prenom','$email','$adresse','$login','$mdp',$tele,'$date',2,$ville) ";
    if(!$conn->query($scr1))
    {
        echo $conn->error;
    }
    else{
    $scr="DELETE FROM inscription WHERE id_inscri=$id_inscri";
    $res=$conn->query($scr);
    Send_Login_to($email,$login);
    header("Location: ListInscri.php", true, 301);
    }
}
CloseCon($conn);
?>