<!DOCTYPE html>
<?php
require_once 'ConnexionToBD.php';
$conn = Conect_ToBD("magasin_en_ligne", "root");
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

<body>
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
                                <button class="miniBut" style="background-color:hsl(120, 100%, 75%); margin-left: 5px;" name="accept" onclick="return confirm('Are you sure?');" ><i class="fa fa-check"></i></button>
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
    



</body>

</html>