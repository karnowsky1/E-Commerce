<?php

    require_once("DBPDO.class.php");

    $db = new DB();

    function createHeader($text, $size="3em", $backColor="#003b64", $color="white"){
        echo '<div class = "header" style = "background-color:' .  "{$backColor}; color: 
        {$color}" . '; ">' . "<p> $text </p>" . "</div>";
    }

    function insertC(){
        global $db; 
        if(isset($_POST['product_id']) && isset($_POST['quantity']) ) {
            $db->insertCart($_POST['product_id'], $_POST['quantity'], "Cart");
        }else{
            echo "DO YOU KNOW THE WAY?";
        }
    }
?>