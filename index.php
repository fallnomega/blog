<?php
/**
 * Created by PhpStorm.
 * User: fallnomega
 * Date: 2/20/2015
 * Time: 1:36 PM
 */


require_once 'lib/common.php';
//connect to the database. run a query, handle errors
$pdo = getPDO();

$stmt = $pdo->query('SELECT id,title, created_at,body FROM post ORDER BY created_at DESC');
if($stmt ===false)
{
    throw new Exception ('There was a problem running this query');
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>A blog application</title>
    <meta http-equiv="content-type" content="text/html;chartset=utf-8"/>
</head>
<body>
<?php require 'templates/title.php' ?>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <h2>
        <?php echo htmlEscape($row['title']) ?>
    </h2>
    <div>
        <?php echo $row['created_at']?>
    </div>
    <p>
        <?php echo htmlEscape($row['body']) ?>
    </p>
        <p>
            <a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read more...</a>
        </p>
<?php endwhile ?>

</body>
</html>
