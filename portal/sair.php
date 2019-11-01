<?php
session_start();
unset($_SESSION['login']);
session_write_close(); 

 echo "<script>window.alert('Obrigado por utilizar o Sistema!')</script>";
       echo" <script>window.parent.location='index.php'</script>";
        
        ?>
    