<?php

	// your functions may be here

	/* start --- black box */
	function getArticles(): ?array
	{
		if( ! $data = file_get_contents('db/articles.json') ) return null;

		return json_decode( $data, true );
	}

	function addArticle( string $title, string $content ): ?int
	{
		if( ! $articles = getArticles() ) return null;

		$lastId			= end($articles)['id'];
		$id				= $lastId + 1;
		$articles[$id]	= [
			'id'		=> $id,
			'title'		=> $title,
			'content'	=> $content
		];

		if( ! saveArticles( $articles ) ) return null;

		return $id;
	}

	function removeArticle( int $id ): bool
	{
		if( ! ( $articles = getArticles() ) || ! isset( $articles[$id] ) ) return false;

		unset( $articles[$id] );

		if( ! saveArticles( $articles ) ) return false;

		return true;
	}

	function editArticle( int $id, string $title, string $content ): bool
	{
		if( ! ( $articles = getArticles() ) || ! isset( $articles[$id] ) ) return false;

		$articles[$id]['title']		= $title;
		$articles[$id]['content']	= $content;

		if( ! saveArticles( $articles ) ) return false;

		return true;
	}

	function getArticle( int $id ): ?array
	{
		if( ! ( $articles = getArticles() ) || ! isset( $articles[$id] ) ) return null;

		return $articles[$id];
	}

	function checkIdError( $id ): string
	{
		return ( $id && ctype_digit( $id ) ) ? '' : 'ID is missing or incorrect';
	}

	function saveArticles( array $articles ): bool
	{
		if( ! file_put_contents( 'db/articles.json', json_encode( $articles ) ) ) return false;

		return true;
	}
	/* end --- black box */