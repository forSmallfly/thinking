<?php

namespace app\utils;

/**
 * RSA工具库
 */
trait RsaTool
{
    /**
     * RSA加密
     *
     * @param string $data
     * @return string
     */
    protected function encryptRSA(string $data): string
    {
        // 公钥
        $publicKey = config('rsa.public_key');
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return base64_encode($encrypted);
    }

    /**
     * RSA解密
     *
     * @param string $base64Encrypted
     * @return string
     */
    protected function decryptRSA(string $base64Encrypted): string
    {
        // 私钥
        $privateKey = config('rsa.private_key');
        $encrypted  = base64_decode($base64Encrypted);
        openssl_private_decrypt($encrypted, $decrypted, $privateKey);
        return $decrypted;
    }
}