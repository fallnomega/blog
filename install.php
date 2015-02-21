<?php
/**
 * Created by PhpStorm.
 * User: fallnomega
 * Date: 2/20/2015
 * Time: 3:48 PM
 */

//get the pdo ds string
$root = realpath(__DIR__);
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:'. $database;

$error ='';

//a security measure, to avoid anyone resetting the database if it already exists
if(is_readable($database)&& filesize($database)>0)
{
    $error = 'Please delete the existing database manually before installing it afresh';
}
//creat an empty file for the database
if(!$error)
{
    $createdOk = @touch($database);
    if(!$createdOk)
    {
        $error = sprintf(
            'Could not create the database, please allow the server to create new files in \'%s\'',
            dirname($database)
        );
    }

}

//grab the sql commands we want to run on the database
if(!$error) {
    $sql = file_get_contents($root . '/data/init.sql');

    if ($sql === false) {
        $error = 'Cannot find SQL file';
    }
}


//connect to the new database and try to run the sql commands
if(!$error)
{
    $pdo = new PDO($dsn);
    $result = $pdo->exec($sql);
    if($result === false){
        $error = 'Could not run SQL:' . print_r($pdo->errorInfo(),true);
    }
}

//see how many rows we created, if any
$count = null;
if(!$error)
{
    $sql = "SELECT COUNT(*) AS c FROM post";
    $stmt = $pdo->query($sql);
    if($stmt)
    {
        $count = $stmt->fetchColumn();
    }
}
?>

<!DOCTYPE html>
    <html>
<head>
    <title>Blog installer</title>
    <meta http-equiv="content-type" content="text/html, charset=utf-8"/>
    <style type="text/css">
        .box
        {
            border: 1px dotted silver;
            border-radius: 5px;
            padding: 4px;
        }
        .error
        {
            background-color: #ff6666;
        }
        .success{
            background-color: #88ff88;
        }
    </style>
</head>
<body>
<?php if($error): ?>
<div class="error box">
    <?php echo $error ?>
</div>
<?php else: ?>
<div class = "success box">
    The database and demo data was created OK.
    <?php if ($count): ?>
    <?php echo $count ?> new rows were created.
    <?php endif ?>
</div>
<?php endif ?>
</body>
</html>