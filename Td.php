<?php 
echo "<h1>Calcule sur les variable</h1>";
$TVA=0.206;
$prix=150;
$qte=10;
$prixHT=($prix+$prix*$TVA)*$qte;
var_dump($TVA,$prix,$qte,$prixHT);

echo"<br>";
$num=random_int(0,100);
if($num%5==0&&$num%3==0) echo"$num est mul de 5 et 3";
else echo"$num n'est pas un mul de 5 et 3";
echo"<br>";
$i=0;
$Somme=0;
while($i<=$num){$Somme+=$i;
    $i++;
}
echo" Somme de 0 a $num avec While est $Somme <br>";
$Somme=0;
for ($i=0; $i <= $num; $i++) $Somme+=$i;
echo" Somme de 0 a $num avec for est $Somme";

?>