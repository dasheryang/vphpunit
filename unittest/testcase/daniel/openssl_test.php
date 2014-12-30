<?php
class OpenSslTest extends PHPUnit_Framework_TestCase {
	
	
	
	function testNewOpenSsl() {
		$dn = array(
		    "countryName" => "CN",
		    "stateOrProvinceName" => "ShenZhen",
		    "localityName" => "NanShan",
		    "organizationName" => "I Dream Sky",
		    "organizationalUnitName" => "I Dream Sky Team",
		    "commonName" => "Daniel.luo",
		    "emailAddress" => "453465565@qq.com"
		);
 
		// Generate a new private (and public) key pair
		$privkey = openssl_pkey_new();
		
		// Generate a certificate signing request
		$csr = openssl_csr_new($dn, $privkey);
		// export certificate
		openssl_csr_export($csr, $out, true);
//		$filename = '/tmp/test.openssl.pem';
//		openssl_csr_export_to_file($csr, $filename);
//		$out = file_get_contents($filename);
		
		var_dump( $privkey, $csr, $out ) ;
		return;	
	}
	
	function testSslSign() {
		// $data is assumed to contain the data to be signed
		// fetch private key from file and ready it
		$filename = '/tmp/test.openssl.pem';
		$fp = fopen($filename, 'r') ;
		$priv_key = fread( $fp, 8192 ) ;
		$priv_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC5Rf9ewAomJL+ZcMwpHhMy8bGgLCRn6SkHePyBeVysTDNch6TW
sHWKad+LGIK+FEPKniPtEnJnp/C7zy1kdakTcQboT2WwFCk8MMCmPeqyeEba79/z
o8MByn1J4INfMnwq9Qr0+MYiXfBk2o3WhsYE34s/pr6vFYCGb4YIKsurwQIDAQAB
AoGBAJRepPI48ie3uCRl+2lWJ2PdwDSYBROd2fidAAGjsf5dC6inC+/N4mNVA+r9
Vv5ndh6V5Alfg3TVPej5Mc3Il/uXp5MSm4ee3kbUBVPvfmHuUAvVKqwVP3KMXMP/
CHHyjOFN9LXsPJ3AJG87r3PvtoqUY44qSRU78lSEA5c4kO39AkEA4sWX842EWqgw
xo1IQs4tXMfmfYIrzF9mh07bVtuKTKn5zHOJAJi/TUG7NBE44MMx9CsfLndM/MJk
rUQHbJP5MwJBANEnJp+peEx9xej5HzMzB16nNdyJzSEW8E6pgET29Xs0H6wslGWL
RPwx2nYrS6SBn/7wh8+g9L3leAU/pBMLzzsCQBsJwDJT30IH57jkw4bjmlkDpKG2
UY6OmWTsrA5RIs49PgF4jQ87JyQJAE8W9pcl7uDT+2XI568DZomaIOB7TC0CQQC5
mpKt8UguKRbuDdVgLBKILr6ffTIqAR8zzzti9/0UXkcVFWKDUjnfy6XgY792twly
xaTf3igSNIZzsew6cqptAkBLkh752NDgYYvgS9LKHzAf+JXYETZIaUb8X82PzeNq
vnpU9GlauoiTizkuwy06ic44srv3KBSYWUaJfYIOM9Zy
-----END RSA PRIVATE KEY-----';
		var_dump( $priv_key ) ;
		$_src_sign = "a=1&b=2&c=3";
		$pkey_id = openssl_get_privatekey( $priv_key );
		// compute signature
		@openssl_sign($_src_sign, $_sign, $pkey_id);
		// free the key from memory
		openssl_free_key($pkey_id);
		var_dump( $_src_sign, $_sign, $pkey_id ) ;
	}
}