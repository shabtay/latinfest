<?php
	function enc( $data ) {
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = "#EDC4rfv%TGB";
		return( openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv) );
	}
	
	function dec( $data ) {
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = "#EDC4rfv%TGB";
		return( openssl_decrypt($data, $ciphering, $encryption_key, $options, $encryption_iv) );
	}
?>