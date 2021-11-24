<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include "Database/database.php";
    $id = $_POST["Id"];
    $sqlNews = "SELECT `Image` FROM `news` WHERE `Id` = ".$id;
    $data = $dbo->query($sqlNews);

    $fileImage = $data->fetchAll()[0]["Image"];

    if(!empty($fileImage)) {
        unlink($_SERVER['DOCUMENT_ROOT']. '/images/'.$fileImage);
    }

   $sql = "DELETE FROM `news` WHERE `Id` =" . $id;
   $dbo->query($sql);
}
