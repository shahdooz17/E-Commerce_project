<?php 
session_start();


    if (isset($_POST['action'])) {
        if ($_POST['action'] == "clear") {
            unset($_SESSION['cart']);
        }

        if ($_POST['action'] == "remove") {
            if(isset($_SESSION['cart'])){
                unset($_SESSION['cart'][$_POST['id']]);
            }
        }
    }



?>