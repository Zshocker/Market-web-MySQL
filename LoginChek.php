<?php 
if($_POST)
{
    require_once 'ConnexionToBD.php';
    $conn = Conect_ToBD("magasin_en_ligne", "root");
    $Log=$_POST['Login'];
    $pass=md5($_POST['mdp']);
    $scr="SELECT type_uti from utilisateur NATURAL JOIN type_uti where login='$Log' and mdp='$pass' ";
    $res=$conn->query($scr);
    $res=$res->fetch_assoc();
    var_dump($res);
    if(empty($res))
    {
        header("Location: index.php", true, 301);
    }
    elseif($res["type_uti"]=="admin")
    {
    header("Location: adminPa.php", true, 301);
    }
    else
    header("Location: index.php", true, 301);
    
}
else header("Location: index.php", true, 301);

?>