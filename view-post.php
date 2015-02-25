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
//swap carriage returns for prargraph breaks
$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n","</p><p>",$bodyText);
?>

<!DOCTYPE html>
<html>
<head>
    <title>
        A blog application |
        <?php echo htmlEscape($row['title']) ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<?php require 'templates/title.php' ?>

<h2>
    <?php echo htmlEscape($row['title']) ?>
</h2>
<div>
    <?php echo convertSqlDate($row['created_at']) ?>
</div>
<p>
    <?php //this is already escaped so doesnt need further escaping ?>
    <?php echo $paraText ?>
</p>
<h3><?php echo countCommentsForPost($postId) ?> comments</h3>

<?php foreach (getCommentsForPost($postId) as $comment): ?>
<?php //for now, we'll use a horizontal rule-off to split it up a bit ?>
<hr />
<div class=""comment">
<div class=""comment-meta">
Comment from
<?php echo htmlEscape($comment['name']) ?>
on
<?php echo convertSqlDate($comment['created_at']) ?>
</div>
<div class=""comment-body">
<?php echo htmlEscape($comment['text']) ?>
</div>
</div>
<?php endforeach ?>



</body>
</html>