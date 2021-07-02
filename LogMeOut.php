<?php 

function LogOut(){
    session_start();
    session_destroy();
    header("Location: index.php", true, 301);
}
logOut();
    
?>