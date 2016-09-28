<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrapPaper.css">
    <title>XSS test</title>
  </head>

  <?php
	include __DIR__ . '/navbar.php'
  ?>
  <div class="col-md-1">
  </div>
  <div class="col-md-10">
<?php

function noXSS($input, $encoding = 'UTF-8')                      /* xss skydd*/
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');   
}


	if($_POST['content']!=null){

		$fp = fopen('comments.txt', 'a');
		fwrite($fp, noXSS($_POST['content']) . "<hr/>\n");
		fclose($fp);
		header("Location: XSS.php");

	}

	echo nl2br(file_get_contents('comments.txt'));

    ?>

    <h3>Post comment</h3>
    <form action="XSS.php" method="post">
    <textarea name="content" rows="3" cols="100"></textarea>
    <br/>
    <input type="submit" value="Post" />
    </form>
	</div>
  <div class="col-md-1">
  </div>
</body>
</html>
