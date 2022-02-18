<?php

define('CIPHERING', "AES-128-CTR");
define('CRYPTION_IV', "1234567891011121");
define('CRYPTION_KEY', "qldkqnfenzdk:1093sQSKéQSOW192s");

function customEncrypt($str) {
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length(CIPHERING);
    $options = 0;
    // Use openssl_encrypt() function to encrypt the data
    return openssl_encrypt($str, CIPHERING, CRYPTION_KEY, 0, CRYPTION_IV);
}

function customDecrypt($str) {
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length(CIPHERING);
    $options = 0;
    // Use openssl_encrypt() function to encrypt the data
    return openssl_decrypt ($str, CIPHERING, CRYPTION_KEY, 0, CRYPTION_IV);
}
?>