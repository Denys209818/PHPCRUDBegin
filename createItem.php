<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    include 'Database/database.php';

    $name = $_POST["name"];
    $desc = $_POST["description"];
    $imageExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $path = uniqid() . ".{$imageExt}";

    move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/images/'.$path);


}