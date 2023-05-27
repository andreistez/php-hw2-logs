<?php

include_once('functions.php');
include_once('model/logs.php');

writeLog();

$id			= 0;
$title		= $content = $err = '';
$success	= false;

if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
	$title		= isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
	$content	= isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '';

	if( ! $title || ! $content ){
		$err = 'Please fill all fields';
	}	else{
		if( $id = addArticle( $title, $content ) ) $success = true;
		else $err = 'Error while adding an article.';
	}
}

if( $success ){
	echo '
		<h2>Thank you, new article #' . $id . ' has been added!</h2>
		<hr />
		<a href="article.php?id=' . $id . '">See new article</a>
	';
}	else{
	?>
	<form method="post">
		<fieldset>
			<label for="title">
				<input id="title" type="text" name="title" value="<?=$title?>" placeholder="Title" />
			</label>
			<label for="content">
				<textarea id="content" name="content" placeholder="Content"><?=$content?></textarea>
			</label>
		</fieldset>

		<button>Submit</button>
	</form>

	<?php
	echo $err;
}
?>

<hr>
<a href="index.php">Move to main page</a>

