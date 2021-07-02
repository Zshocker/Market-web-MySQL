<?php
session_start();

?>
<html>

<head>
    <title>Inscipt</title>

    <link rel="StyleSheet" href="styleForInscrip.css">
    <link rel="StyleSheet" href="prods.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="margin:0px;">

    <div class="bar">
        <div style="padding-top:15px ; height:100%;">
        <a href="index.php"><img src="rw-markets.png" style="width:auto; height:75%; margin-left:25px;"></a>
            <?php if (!isset($_SESSION['id_uti'])) { ?>
                <button class="mi" onclick="show_elem_id('inscrip')">Sign Up</button>
                <button class="mi" onclick="show_elem_id('Login')" style="margin-Right: 5px;">Log In</button>
            <?php
            } else {
            ?>
                <form method="POST" action="LogMeOut.php" style="float:right;">
                    <input type="submit" value="logout" name="Logout" class="mi" onclick="return confirm('Are you sure?');">
                </form>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="cont-92-5">
        <div class="sidebar">
            <?php
            if (isset($_SESSION['id_uti'])) {
            ?>
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
            }
            ?>
        </div>
        <div class="MainCont">


            <?php
            require_once 'ConnexionToBD.php';
            $conn = Conect_ToBD("magasin_en_ligne", "root");
            if (isset($_GET['id'])) {
                $ser = $_GET['id'];
                $scr = "SELECT id_prod,Designation,prix_std,description,reduction,label_cat FROM produit natural join categorie WHERE id_prod=$ser";
            } else header('location: index.php', true, 301);
            $result = $conn->query($scr);
            $qe = $result->fetch_assoc();
            $id_prod = $qe['id_prod'];
            $sc_photo = "SELECT id_photo,photo FROM photo where id_prod=$id_prod";
            $rs = $conn->query($sc_photo);
            $photos=$rs->fetch_all(MYSQLI_ASSOC);
            $name = $qe['Designation'];
            $desc=$qe['description'];
            $cat=$qe['label_cat'];
            $prix = $qe['prix_std'];
            $red = floatval($qe['reduction']);
            $red1 = $prix-$prix*$red;
            ?>

            <div class="ProdDetailCont">
                <div class="imagesProdCont">
                    <div class="MainImageCont">
                        <img class="MainImageS" src="<?php echo $photos[0]['photo']?>" id="MainImageFe">
                    </div>
                    <div class="SwipeDiv">
                        <div class="arrows">
                        <center>
                        <button onclick="shift_left('myse')"><i class="fa fa-angle-left"></i></button>
                        </center>
                        </div>
                        <div class="SwipeBar" id="myse">
                        <?php 
                        $i=0;
                        foreach ($photos as $phot)
                        {$i++;
                        ?>
                        <img src="<?php echo $phot['photo'];?>" id="minphoto-<?php echo $i;?>" onclick="switchSrcImg('MainImageFe','minphoto-<?php echo $i; ?>')">
                        <?php
                        }
                        ?>
                        </div>
                        <div class="arrows" >
                        <center>
                        <button onclick="shift_Right('myse')"><i class="fa fa-angle-right"></i></button>
                        </center>
                        </div>
                    </div>
                </div>
                <div class="Second-Detail">
                <div class="mainDetailFr">
                    <span class="MainText"><?php echo $name;?></span><hr style="border-block-color: black;margin: top 4px ;" ><hr style="border-block-color: black;margin: top 4px;">
                    <span style="font-size:25px;">Prix:  <span style="color:#B12704; "><?php echo $red1;?> dh    </span></span>
                    <?php 
                    if($red>0){ echo "<del style='font-size:20px; color:grey;'>$prix dh</del>"; }
                    ?>
                    <br><br><br><br><br>
                     <span style="font-size:25px;">Description: <br></span>
                     <span style="font-size:20px;"><?php echo $desc;?></span>
                     <br><br><br><br><br>
                     <span style="font-size:25px;">Categorie: <br></span>
                     <span style="font-size:20px;"><?php echo $cat;?></span>
                     
                </div>
               <?php if(isset($_SESSION['id_uti'])){ ?>
                <div class="Comand">
                    <hr style="border-block-color: black;margin: top 4px ; bottom:0;" >
                    <form action="PanierFill.php" method="POST">
                    <input type="hidden" name="id_prod" value="<?php echo $ser;?>">
                    <button type="submit" name="ButnAj" class="mi">Ajouter aux panier </button>
                    <input type="text" name="qte" placeholder="qte" style="width:15%; float:right" onkeypress="return onlyNumberKey(event)" required>
                    </form>
                </div>
                <?php } ?>
                </div>
            </div>


        </div>
    </div>


    <div class="modal" id="inscrip">
        <center>
            <div class="container">
                <div class="row">
                    <button class="mi" onclick="unshow_elem_id('inscrip')">&times;</button>
                </div>
                <form action="insert_inscription.php" method="POST">
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">Prenom: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="fname" name="Prenom" placeholder="Votre prenom.." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Nom: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="lname" name="Nom" placeholder="votre Nom.." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="Email">Email: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="Email" name="Email" placeholder="votre Email.." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="mdp">Mot de passe: </label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="mdp" name="mdp" placeholder="Creer un mdp.." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="tele">Telephone: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="tele" name="tele" placeholder="votre Tel..">
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
                        <div class="col-25">
                            <label for="adresse">Adresse</label>
                        </div>
                        <div class="col-75">
                            <textarea id="adresse" name="adresse" placeholder="Write something.." style="height:200px" maxlength="100" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </center>
    </div>
    <div class="modal" id="Login">
        <center>
            <div class="container">
                <div class="row">
                    <button class="mi" onclick="unshow_elem_id('Login')">&times;</button>
                </div>
                <form action="LoginChek.php" method="POST">
                    <div class="row">
                        <div class="col-25">
                            <label for="Log">Login: </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="log" name="Login" placeholder="Votre Login.." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="md">Mot de passe: </label>
                        </div>
                        <div class="col-75">
                            <input type="password" id="md" name="mdp" placeholder="votre mot de passe.." required>
                        </div>
                        <div class="row">
                            <input type="submit" value="Log In">
                        </div>
                </form>
            </div>
        </center>
    </div>
</body>
<script src="JS Scripts/name.js"></script>
<script>
    function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if ((ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
        function shift_Right(id)
        {
            var CWE=document.getElementById(id);
            CWE.scrollLeft+=180;
            
        }
        function shift_left(id)
        {
            var CWE=document.getElementById(id);
            CWE.scrollLeft-=180;
        }

</script>
</html>