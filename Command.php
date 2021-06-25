<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if ($_POST) {
    if(!isset($_POST['prods'])) header("Location: PanierPa.php", true, 301);
    $tabPRods = $_POST['prods'];
    $tabqte = $_POST['qte'];
    $prixTot=0;
?>
    <html>

    <head>
        <title>Commade</title>

        <link rel="StyleSheet" href="styleForInscrip.css">
        <link rel="StyleSheet" href="prods.css">
        <link rel="StyleSheet" href="tableStyle.css">
        <script src="JS Scripts/name.js"></script>
    </head>

    <body style="margin:0px;">

        <div class="bar">
            <div style="padding-top:15px ; height:100%;">
                <?php if (!isset($_SESSION['id_uti'])) {
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
            <h1>Votre Commande :</h1>
            <div class="table-wrapper">
                <center>
                    <table class="fl-table">
                        <thead>
                            <tr>
                                <th colspan=3>Detail</th>
                                <th>prix</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $len = count($tabPRods);
                            for ($i = 0; $i < $len; $i++) {
                                $scr = "SELECT Designation,prix_std,reduction FROM produit WHERE id_prod=$tabPRods[$i] ";
                                $result = $conn->query($scr);
                                $qe = $result->fetch_assoc();
                                $id_prod = $tabPRods[$i];
                                $name = $qe['Designation'];
                                $prix = $qe['prix_std'];
                                $red = floatval($qe['reduction']);
                                $detail="$tabqte[$i]*$name";
                                $prix=($prix-$prix*$red)*$tabqte[$i];
                                $prixTot+=$prix;
                            ?>
                                <tr>
                                    <td colspan=3><?php echo "$detail" ?></td>
                                    <td><?php echo "$prix" ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr background-color="blue">
                                    <td colspan=3 style="background-color:aqua;">Prix Totale :</td>
                                    <td  style="background-color:aqua;"><?php echo "$prixTot" ?></td>
                            </tr>
            </div>
        </div>



    </body>

    </html>

<?php
}
CloseCon($conn);
?>