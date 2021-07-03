<?php
session_start();
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
if ($_POST) {
    if (!isset($_POST['prods'])) header("Location: PanierPa.php", true, 301);
    $tabPRods = $_POST['prods'];
    $tabqte = $_POST['qte'];
    $prixTot = 0;
   
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
            <h1 style="margin-top: 0px;">Votre Commande :</h1>
            <center>
            <div class="table-wrapper">
               
                    <form method="POST" action="PassCommande.php">
                        <?php 
                        if(isset($_POST['Not_pan'])){
                        ?>
                        <input type="hidden" name="Not_pan" value="true">
                        <?php 
                        }
                        ?>
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
                                    $detail = "$tabqte[$i]*$name";
                                    $prix = ($prix - $prix * $red) * $tabqte[$i];
                                    $prixTot += $prix;
                                ?>
                                    <tr>
                                        <input type="hidden" name="ProdIds[]" value="<?=$tabPRods[$i]?>">
                                        <input type="hidden" name="qteP[]" value="<?=$tabqte[$i]?>">
                                        <td colspan=3><?php echo "$detail" ?></td>
                                        <td><?php echo "$prix" ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr background-color="blue">
                                    <td colspan=3 style="background-color:aqua;">Prix Totale :</td>
                                    <td style="background-color:aqua;"><?php echo "$prixTot" ?></td>
                                </tr>

                            </tbody>
                        </table>

                        Type De paiment:<select name="type Paiment" style="width: 10%;" required onchange="Display_info(this.value)" id="typePai">
                            <option></option>
                            <option value="1">Carte</option>
                            <option value="2">espece</option>
                            <option value="3">cheque</option>
                        </select>
                        <div style="display: none; margin:10px;" id="Carte_info">
                            <select name="type-Carte" style="width: 10%;" id="TypeCa" placeholder="Type de Carte:">
                                <?php
                                $scr = "SELECT * FROM type_carte ";
                                $result = $conn->query($scr);
                                while ($qe = $result->fetch_assoc()) {
                                    $id_T = $qe['id_typecarte'];
                                    $ty = $qe['type_carte'];
                                    echo "<option value='$id_T'>$ty</option>";
                                }
                                ?>
                            </select>
                            <input type="number" class="myInput" placeholder="Carte Number" id="CaNum" style=" width: 25%;">
                            <input type="password" placeholder="CVV" id="CVV" style="width: 60px;">
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="adresse">Adresse de livration :</label>
                            </div>
                            <div class="col-75">
                                <?php
                                $id_uti=$_SESSION['id_uti'];
                                $scr = "SELECT adresse FROM utilisateur where id_uti=$id_uti";
                                $result = $conn->query($scr);
                                $qe = $result->fetch_assoc();
                                $adres=$qe["adresse"];
                                CloseCon($conn);
                                ?>
                                <textarea id="adresse" name="adresse" placeholder="Write something.." style="height:200px" maxlength="100" required><?= $adres ?></textarea>
                            </div>
                        </div>
                        <a href="PanierPa.php" onclick="return confirm('are you sure?');" ><button type="button" class="mi" name="confirm">Retourner</button></a>
                        <button class="mi" name="Confirm">Confirmer</button>
                    </form>
              
            </div>
            </center>
        </div>



    </body>
    <script>
        function Display_info(value) {
            if (Number(value) == 1) {
                document.getElementById("Carte_info").style.display = "block";

            } else {
                document.getElementById("Carte_info").style.display = "none";

            }
        }
    </script>

    </html>

<?php
}
CloseCon($conn);
?>