<?php

function getCurrentLogPath(): string { return 'logs/' . date( 'Y-m-d' ) . '.log'; }

function checkLogExtension( string $file_name ): bool
{
	if( ! $file_name ) return false;

	return !! preg_match( '/^.*\.log$/i', $file_name );
}

function getFileNameWithoutExtension( string $file_name ): ?string
{
	if( ! $file_name ) return null;

	return preg_replace( '/\.[^.]+$/', '', $file_name );
}

function writeLog(): bool
{
	$time	= date( 'H:i:s' );
	$ip		= isset( $_SERVER['REMOTE_ADDR'] ) ? "|{$_SERVER['REMOTE_ADDR']}" : '';
	$uri	= isset( $_SERVER['REQUEST_URI'] ) ? "|{$_SERVER['REQUEST_URI']}" : '';
	$ref	= isset( $_SERVER['HTTP_REFERER'] ) ? "|{$_SERVER['HTTP_REFERER']}" : '';
	$line	= $time . $ip . $uri . $ref . "\n";

	$f = fopen( getCurrentLogPath(), 'a' );
	$write = fwrite( $f, $line );
	fclose( $f );

	if( ! $write ) return false;

	return true;
}

function getLogsFiles(): array
{
	$files = scandir( 'logs' );

	return array_filter( $files, function( $f ){
		return ( is_file( "logs/$f" ) && checkLogExtension( $f ) );
	} );
}

function getLogFileContent( $log_name ): array
{
	if( ! $contents = file( "logs/$log_name", FILE_IGNORE_NEW_LINES ) ) return [];

	return $contents;
}

