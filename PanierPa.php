<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
$id_uti=$_SESSION['id_uti'];
$scr = "SELECT id_prod,Designation,Description,prix_std,reduction,label_cat,id_cat,qte FROM  panier NATURAL JOIN avoir_pan_pro NATURAL JOIN produit NATURAL JOIN categorie WHERE id_uti=$id_uti ORDER BY id_prod ";
$result = $conn->query($scr);
?>

<html>

<head>
    <title>Les produits</title>
    <script src="JS Scripts/name.js"></script>
    <link rel="StyleSheet" href="styleForInscrip.css">
    <link rel="StyleSheet" href="tableStyle.css">
    <link rel="StyleSheet" href="prods.css">
    <link rel="stylesheet" href="CssFontA/css/all.css">
    
</head>

<body style="margin:0px;">
    <div class="bar">
        <div style="height:100%;">
        <a href="index.php"><img src="rw-markets.png" style="width:auto; height:75%; margin-left:25px;"></a>
            <?php if (!isset($_SESSION['id_uti'])) {
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
            <?php
            if ($_SESSION['type_uti'] == 'admin') {
            ?>
                <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='adminPa.php';">Gestion des produits</button></div>
                <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListInscri.php';">Afficher les inscription</button></div>
                <div class="sideBDiv"><button class="sideBut" onclick="window.location.href='ListUti.php';">Afficher les utilisateurs</button></div>
            <?php
            }
            ?>
        </div>
        <div class="MainCont">
            <div class="navBar">
                <input type="text" name="search" class="searchBar" id="searcher" placeholder="Search" onkeypress="Research('searcher',event)">
            </div>
            <div class="table-wrapper">
                <center>
                    <table class="fl-table">
                        <thead>
                            <tr>
                                <th>Confirmer</th>
                                <th>image</th>
                                <th>Nom</th>
                                <th>prix</th>
                                <th>reduction</th>
                                <th>description</th>
                                <th>categorie</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($qe = $result->fetch_assoc()) {
                                $qte = $qe['qte'];
                                $id_prod = $qe['id_prod'];
                                $sc_photo = "SELECT MIN(id_photo),photo FROM photo where id_prod=$id_prod";
                                $rs = $conn->query($sc_photo);
                                $rs = $rs->fetch_assoc();
                                $imag = $rs['photo'];
                                $name = $qe['Designation'];
                                $desc = $qe['Description'];
                                $prix = $qe['prix_std'];
                                $red = floatval($qe['reduction']);
                                $redP = $red * 100;
                                $cat = $qe['label_cat'];
                                $id_cat = $qe['id_cat'];

                            ?>
                                <tr name="prod" id="<?php echo "$id_prod" ?>">
                                    <td>
                                    <input type="checkbox" id="check-<?php echo "$id_prod" ?>" onchange="Gest_hidden('<?php echo $id_prod; ?>')">
                                    </td>
                                    <td name="Image"><img src="<?php echo $imag; ?>" style="width:50px;height:50px;"></td>
                                    <td id="name-<?php echo "$id_prod" ?>"><?php echo "$name" ?></td>
                                    <td id="prix-<?php echo "$id_prod" ?>"><?php echo "$prix" ?></td>
                                    <td name="reduction"><?php echo "$redP" ?>%</td>
                                    <td name="desc"><?php echo "$desc" ?></td>
                                    <td name="cat"><?php echo "$cat" ?></td>
                                    <td name="checked">
                                        Qte a commander:<input type="number" id="qte-<?php echo "$id_prod" ?>" name="qte" placeholder="qte" class="myInput"  style="width: 60px; height:75%;"  placeholder="qte a commander" value="<?php echo $qte; ?>" min="1" onchange="chek_qte(event,'<?php echo $id_prod; ?>',<?php echo $qte; ?>)" required>
                                        <button class="miniBut" style="background-color: red; width:30px; height: 30px;" name="Delete" onclick="Delete('<?php echo $id_prod; ?>'); "><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <tbody>
                    </table>
                </center>
                <form action="Command.php" method="POST" id="formCom">

                    <button class="mi" name="Commander" onclick="return confirm('are you sure?');">Commander</button>
                </form>
            </div>

        </div>
    </div>

</body>
<script>
        function Get_Search(str) {
            return document.getElementById(str).value;
        }

        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if ((ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function chek_qte(evt, id, qte) {
            if (!onlyNumberKey(evt)) return false;
            var val = document.getElementById('qte-' + id).value;
            if(Number(val)<=0)document.getElementById('check-' + id).checked=false;
            var element = document.getElementById('hiddqte-' + id);
            if (typeof(element) != 'undefined' && element != null)
            {
                element.value=val;
            }
            return true;
        }

        function Research(str, evt) {
            var val = Get_Search(str);
            if (evt.which != 13) val += String.fromCharCode(evt.which);
            var ters = document.getElementsByName('prod');
            var len = ters.length;
            for (var i = 0; i < len; i++) {
                ters[i].style.removeProperty('display');
                var id = ters[i].id;
                var name = document.getElementById('name-' + id).innerHTML;
                if (name.toLocaleLowerCase().indexOf((val).toLocaleLowerCase()) < 0)
                    ters[i].style.display = "none";

            }
        }

        function Gest_hidden(id) {
            var check = document.getElementById('check-' + id);
            var valueCon= document.getElementById('qte-' + id).value;
            if(Number(valueCon)<=0){
                check.checked=false;
                return;
            }

            var fer = document.getElementById('formCom');
            if (check.checked) {
                fer.innerHTML += '<input type="hidden" id="hiddId-' + id + '" name="prods[]" value="' + id + '">';
                var qte = document.getElementById('qte-' + id).value;
                fer.innerHTML += '<input type="hidden" id="hiddqte-' + id + '" name="qte[]" value="' + qte + '">';
            } else {
                var element = document.getElementById('hiddId-' + id);
                if (typeof(element) != 'undefined' && element != null) {
                    var lud=document.getElementById('hiddqte-'+id);
                    element.remove();
                    lud.remove();
                }
            }
        }
        function Delete(id_prod)
        {
            if(!confirm("Are you sure"))return false;
            window.location.href='Delete_from_pan.php?id='+id_prod;
        }
    </script>
</html>