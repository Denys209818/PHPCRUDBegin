<?php
require_once 'database_config.php';
try {
    $dbo = new PDO(DB_SERVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND =>
            "SET NAMES " . DB_CHARSET));
}catch (Exception $ex)
{
    echo "Connect with database error: " . $ex->getMessage();
    exit();
}
