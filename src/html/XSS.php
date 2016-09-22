<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrapPaper.css">
    <title>XSS test</title> 
  </head>

<?php
/*include __DIR__ . '/navbar.php'*/

	if($_POST['content']!=null){

		$fp = fopen('comments.txt', 'a');
		fwrite($fp, $_POST['content'] . "<hr/>\n");
		fclose($fp);

	}

	echo nl2br(file_get_contents('comments.txt'));

    ?>   

    <h3>Post comment</h3>
    <form action="XSS.php" method="post">
    <textarea name="content" rows="3" cols="100"></textarea>
    <br/>
    <input type="submit" value="post" />
    </form>
	
</body> 
</html>
		