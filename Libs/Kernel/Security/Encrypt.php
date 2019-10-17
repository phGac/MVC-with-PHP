<?php

namespace Kernel\Security;

class Encrypt
{
    private $algorithm;
    private $key;
    private $iv;

    function __construct()
    {
        $this->algorithm = 'AES-256-CBC';
        $this->key = 'For God so loved the world, ... - John 3:16'; //, that he gave his only Son, that whoever believes in him should not perish but have eternal life. - John 3:16
        $this->iv = '141767';
    }

    public function encrypt($toEncrypt){
        $key = hash( 'sha256', $this->key );
        $iv = substr( hash( 'sha256', $this->iv ), 0, 16 );
        $encrypted = openssl_encrypt( $toEncrypt, $this->algorithm, $key, 0, $iv );
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }

    public function decrypt($toDecrypt){
        $key = hash( 'sha256', $this->key );
        $iv = substr( hash('sha256', $this->iv ), 0, 16 );
        $decrypted = openssl_decrypt( base64_decode($toDecrypt), $this->algorithm, $key, 0, $iv );
        return $decrypted;
    }

}

?>