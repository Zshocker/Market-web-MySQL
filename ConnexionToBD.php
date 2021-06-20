<?php 
function Conect_ToBD($Bd,$usr)
{
    $dbhost="localhost";
    $dbmdp="";
    
    $conn=new mysqli($dbhost,$usr,$dbmdp,$Bd);
    
    if(!$conn)
    {
        echo "connexion failed : $conn->error";
       
    }
    else
    {
        
        return $conn;
    }
}
function CloseCon($conn)
 {
    $conn -> close();
 }
?>