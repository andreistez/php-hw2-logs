<?php

include_once( 'functions.php' );

$title		= $content = '';
$success	= false;

if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
	$id		= isset( $_GET['id'] ) ? trim( $_GET['id'] ) : 0;
	$err	= checkIdError( $id );

	if( $id && ( $article = getArticle( $id ) ) ){
		$title		= $article['title'];
		$content	= $article['content'];
	}
}	else{
	$id			= isset( $_POST['id'] ) ? trim( $_POST['id'] ) : 0;
	$err		= checkIdError( $id );
	$title		= isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
	$content	= isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '';

	if( ! $title || ! $content ){
		$err = 'Please fill all fields';
	}	else{
		if( editArticle( $id, $title, $content ) ) $success = true;
		else $err = 'Error while editing an article.';
	}
}

if( $success ){
	echo "
		<h2>Thank you, article $id has been updated!</h2>
		<hr />
		<a href=\"article.php?id={$id}\">See updates</a>
	";
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
			<input type="hidden" name="id" value="<?=$id?>" />
		</fieldset>

		<button>Submit</button>
	</form>

	<?php
	echo $err;
}
?>

<hr>
<a href="index.php">Move to main page</a>

