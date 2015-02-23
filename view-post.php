<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2/23/2015
 * Time: 12:43 PM
 */

require_once 'lib/common.php';

//get the post ID
if(isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    //so we always have a post if var defined
    $postId = 0 ;
}

//connect to the database, run a query, handle errors

$pdo = getPDO();
$stmt = $pdo->prepare(
    'SELECT title, created_at,body FROM post WHERE id= :id'
);
if($stmt ===false)
{
    throw new Exception('There was a problem preparing this query');
}
$result = $stmt->execute(
    array('id'=>$postId,)
);
if($result === false)
{
    throw new Exception('There was a problem running this query');
}

//get a row
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
    <html>
<head>
    <title>
    A blog application
    <?php echo htmlspecialchars($rwo['title'],ENT_HTML5,'UTF-8')?>
    </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1>Blog title</h1>
<p>
    This paragraph summarises what the blog is about.
</p>
<h2>
    <?php echo htmlspecialchars($row['title'],ENT_HTML5,'utf-8')?>
</h2>
<div>
    <?php echo $row['created_at']?>
</div>
<p>
    <?php echo htmlspecialchars($row['body'],ENT_HTML5,'utf-8')?>
</p>
</body>



</html>