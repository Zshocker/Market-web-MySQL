<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");

if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $scr = "SELECT id_commande,date_com,adresse_liv,id_uti,etat_com,id_paiementE,id_paiementCa FROM commande  NATURAL JOIN etat_commande where date_com like '%$search%' or adresse_liv like '%$search%' ORDER BY id_commande ";
    } else
    $scr = "SELECT id_commande,date_com,adresse_liv,id_uti,etat_com,id_paiementE,id_paiementCa FROM commande NATURAL JOIN etat_commande  ORDER BY id_commande";
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
        <div style="padding-top:15px ; height:100%;">
            <?php if (!isset($_SESSION['id_uti'])) {
                header("Location: index.php", true, 301);
            } elseif ($_SESSION['type_uti'] != 'admin') {
                header("Location: index.php", true, 301);
            } else {
                ?>
                <form method="POST" action="LogMeOut.php">
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
                <button type="submit" class="miniBut" onclick="window.location.href='CommandePa.php?search='+Get_Search('searcher');" style="margin-top:8px; width: 30px; height: 32px;"><i class="fa fa-search"></i></button>
            </div>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>id_commande</th>
                            <th>date_com</th>
                            <th>adresse_liv</th>
                            <th>id_uti</th>
                            <th>etat</th>
                            <th>type paiement</th>
                            <th> informations paiement </th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($qe = $result->fetch_assoc()) {
                            $id_commande = $qe['id_commande'];
                            $id_uti = $qe['id_uti'];
                            $adresse = $qe['adresse_liv'];
                            $date = $qe['date_com'];
                            $etat = $qe['etat_com'];
                            $id_paiementE = $qe['id_paiementE'];
                            $id_paiementCa = $qe['id_paiementCa'];
                            //$type_c=$qe['type_carte'];

                            ?>
                            <tr>
                                <td><?php echo "$id_commande" ?></td>
                                <td><?php echo "$date" ?></td>
                                <td><?php echo "$adresse" ?></td>
                                <td><?php echo "$id_uti" ?></td>
                                <td><?php echo "$etat" ?></td>
                                <td><?php if ($id_paiementE != '') {
                                        $var = 1;
                                        echo "espece";
                                    }
                                    elseif($id_paiementCa != '') {
                                        $var =2;
                                        echo "carte";
                                    }
                                    else {$var=3;
                                    echo "chèque";} ?></td>
                                <td> <?php if ($var==2) {
                                            $scr = "SELECT type_carte from type_carte NATURAL JOIN paiement_carte where id_commande=$id_commande";
                                            $res = $conn->query($scr);
                                            $res = $res->fetch_assoc();
                                            $tp = $res['type_carte'];
                                            echo "$tp";
                                        } 
                                        elseif($var==1) {
                                            $scr = "SELECT date_paiementE from paiement_espece  where id_commande=$id_commande";
                                            $res = $conn->query($scr);
                                            $res = $res->fetch_assoc();
                                            $tp = $res['date_paiementE'];
                                            echo "$tp";    
                                        }  
                                        elseif($var==3){
                                            ?>
                                            <button class="miniBut" style="background-color: aqua;" name="afficher" onclick="show_elem_id('info_cheque-<?php echo $id_commande;?>')"><i class="fa fa-plus"></i></button>
                                            <?php 

                                        }  ?></td>
                                        
                                



                                <!--<td>
                                        <form method="POST" action="inscri_D_V.php">
                                            <input type="hidden" name="id_inscri" value="<?php 
                                                                                            ?>*/">
                                            <button class="miniBut" style="background-color:hsl(120, 100%, 75%); margin-left: 5px;" name="accept" onclick="return confirm('Are you sure?');"><i class="fa fa-check"></i></button>
                                            <button class="miniBut" style="background-color: red;" name="Delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></button>

                                        </form>
                                    </td>-->
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
    function Get_Search(str) {
        return document.getElementById(str).value;
    }
</script>

</html>