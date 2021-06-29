<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if(isset($_GET['search']))
{
    $search=$_GET['search'];
    $scr = "SELECT id_uti,nom,prenom,email,adresse,login,tele,date_inscris,ville,type_uti FROM type_uti NATURAL JOIN utilisateur NATURAL JOIN ville where nom like '%$search%' or prenom like '%$search%' ORDER BY id_uti ";
}
else
$scr = "SELECT id_uti,nom,prenom,email,adresse,login,tele,date_inscris,ville,type_uti FROM type_uti NATURAL JOIN utilisateur NATURAL JOIN ville  ORDER BY id_uti ";
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
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='CommandPa.php';">Afficher Mes Commandes</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='adminPa.php';">Gestion des produits</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListInscri.php';">Afficher les inscription</button></div>
            <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListUti.php';">Afficher les utilisateurs</button></div>
            
        </div>
            <div class="MainCont">
                <div class="navBar">
                    <input type="text" name="search" class="searchBar" id="searcher" placeholder="Search">
                    <button type="submit" class="miniBut" onclick="window.location.href='ListUti.php?search='+Get_Search('searcher');" style="margin-top:8px; width: 30px; height: 32px;"><i class="fa fa-search"></i></button>
                    <button class="mi" onclick="show_elem_id('Ajuti')" style="background-color:hsl(120, 100%, 75%);"><i class="fa fa-plus" aria-hidden="true"></i>&emsp;Ajouter des utilisateurs</button>
                </div>
            <div class="table-wrapper">
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>login</th>
                            <th>ville</th>
                            <th>téléphone</th>
                            <th>date_inscription</th>
                            <th>type</th>
                            <th>action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($qe = $result->fetch_assoc()) {
                            $id_uti = $qe['id_uti'];
                            $name = $qe['nom'];
                            $prenom = $qe['prenom'];
                            $email = $qe['email'];
                            $adresse = $qe['adresse'];
                            $login=$qe['login'];
                            //$mdp = $qe['mdpI'];
                            $tele = $qe['tele'];
                            $date = $qe['date_inscris'];
                            $ville = $qe['ville'];
                            $type=$qe['type_uti'];
                            //$id_panier=$qe['id_panier'];


                        ?>
                            <tr>
                                <td><?php echo "$name" ?></td>
                                <td><?php echo "$prenom" ?></td>
                                <td><?php echo "$email" ?></td>
                                <td><?php echo "$adresse" ?></td>
                                <td><?php echo "$login" ?></td>
                                <td><?php echo "$ville" ?></td>
                                <td><?php echo "$tele" ?></td>
                                <td><?php echo "$date" ?></td>
                                <td><?php echo "$type" ?></td>
                                

                                <td>
                                    <?php
                                    if($type!="admin"){
                                    ?>
                                    <form method="POST" action="uti_D_I.php">
                                        <input type="hidden" name="id_uti" value="<?php echo $id_uti; ?>">
                                        <button class="miniBut" style="background-color: red;" name="Delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></button>

                                    </form>
                                    <?php
                                    }
                                    ?>
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
    <div class="modal" id='Ajuti'>
        <center>
            <div class="container">
                <div class="row">
                    <button class="mi" onclick="unshow_elem_id('Ajuti')">&times;</button>
                </div>
                <form action="utilisateur.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-25">
                            <label for="nomu"> Nom: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="nom" name="nom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="prenomu">Prenom: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="prenom" name="prenom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="emailu"> Email </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="adresseu"> Adresee </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="adresse" name="adresse" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="mdpu"> Mot De Pass </label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="mdp" name="mdp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="teleu"> Téléphone </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="tele" name="tele" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="typeu">Type</label>
                        </div>
                        <div class="col-75">
                            <select id="type" name="type">
                                <?php

                                $resultE = $conn->query("Select * from type_uti");
                                while ($qe = $resultE->fetch_assoc()) {
                                    $content = $qe['type_uti'];
                                    $id = $qe['id_type'];
                                    echo "<option value=\"$id\"> $content </option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ville">Ville:</label>
                        </div>
                        <div class="col-75">
                        <select id="ville" name="ville">
                            <?php
                            $result = $conn->query("Select * from ville");
                            while ($qe = $result->fetch_assoc()) {
                            $content = $qe['ville'];
                            $id = $qe['id_ville'];
                            echo "<option value=\"$id\"> $content </option>";
                            }
                            CloseCon($conn);
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </center>
    </div>



</body>
<script>
    function Get_Search(str)
        {
            return document.getElementById(str).value;
        }
</script>

</html>
