<?php

function getCurrentLogPath(): string { return 'logs/' . date( 'Y-m-d' ) . '.log'; }

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

