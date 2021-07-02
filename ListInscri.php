<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if(isset($_GET['search']))
{
    $search=$_GET['search'];
    $scr = "SELECT id_inscri,nomI,prenomI,emailI,adresseI,mdpI,teleI,date_inscriI,ville FROM inscription NATURAL JOIN ville where nomI like '%$search%' or prenomI like '%$search%' ORDER BY id_inscri ";
}
else
$scr = "SELECT id_inscri,nomI,prenomI,emailI,adresseI,mdpI,teleI,date_inscriI,ville FROM inscription NATURAL JOIN ville ORDER BY id_inscri ";
$result = $conn->query($scr);
?>

<html>

<head>
    <title>Les inscriptions</title>
    <script src="JS Scripts/name.js"></script>
    <link rel="StyleSheet" href="styleForInscrip.css">
    <link rel="StyleSheet" href="tableStyle.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="margin:0px;">
    <div class="bar">
        <div style="height:100%;">
        <a href="index.php"><img src="rw-markets.png" style="width:auto; height:75%; margin-left:25px;"></a>
            <?php if (!isset($_SESSION['id_uti'])) {
                header("Location: index.php", true, 301);
            } elseif ($_SESSION['type_uti'] != 'admin') {
                header("Location: index.php", true, 301);
            } else {
                ?>
                <form method="POST" action="LogMeOut.php" style="float:right; margin:0px">
                    <input type="submit" value="logout" name="Logout" class="mi" onclick="return confirm('Are you sure?');">
                </form>
            <?php
        }
        ?>
        </div>
    </div>

    <div class="cont-92-5">
        <div class="sidebar">
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ClientPa.php';">Consulter les produits</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='PanierPa.php';">Afficher Mon panier</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='CommandePa.php';">Afficher Mes Commandes</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='adminPa.php';">Gestion des produits</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListInscri.php';">Afficher les inscription</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListUti.php';">Afficher les utilisateurs</button></div>
        </div>
        <div class="MainCont">
            <div class="navBar">
                <input type="text" name="search" class="searchBar" id="searcher" placeholder="Search">
                <button type="submit" class="miniBut" onclick="window.location.href='ListInscri.php?search='+Get_Search('searcher');" style="margin-top:8px; width: 30px; height: 32px;"><i class="fa fa-search"></i></button>
            </div>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>ville</th>
                            <th>telephone</th>
                            <th>date_inscription</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($qe = $result->fetch_assoc()) {
                            $id_inscri = $qe['id_inscri'];
                            $name = $qe['nomI'];
                            $prenom = $qe['prenomI'];
                            $email = $qe['emailI'];
                            $adresse = $qe['adresseI'];
                            $mdp = $qe['mdpI'];
                            $tele = $qe['teleI'];
                            $date = $qe['date_inscriI'];
                            $ville = $qe['ville'];

                            ?>
                            <tr>
                                <td><?php echo "$name" ?></td>
                                <td><?php echo "$prenom" ?></td>
                                <td><?php echo "$email" ?></td>
                                <td><?php echo "$adresse" ?></td>
                                <td><?php echo "$ville" ?></td>
                                <td><?php echo "$tele" ?></td>
                                <td><?php echo "$date" ?></td>
                                <td>
                                    <form method="POST" action="inscri_D_V.php">
                                        <input type="hidden" name="id_inscri" value="<?php echo $id_inscri; ?>">
                                        <button class="miniBut" style="background-color:hsl(120, 100%, 75%); margin-left: 5px;" name="accept" onclick="return confirm('Are you sure?');"><i class="fa fa-check"></i></button>
                                        <button class="miniBut" style="background-color: red;" name="Delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></button>

                                    </form>
                                </td>
                            </tr>
                        <?php
                    }
                    ?>
                    <tbody>
                </table>
            </div>
        </div>
    </div>



</body>
<script>
    function Get_Search(str)
        {
            return document.getElementById(str).value;
        }
</script>

</html>