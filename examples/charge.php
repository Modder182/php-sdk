<?php

require_once __DIR__ . '/../vendor/autoload.php';

use WayForPay\SDK\Collection\ProductCollection;
use WayForPay\SDK\Credential\AccountSecretTestCredential;
use WayForPay\SDK\Domain\Card;
use WayForPay\SDK\Domain\Client;
use WayForPay\SDK\Domain\Product;
use WayForPay\SDK\Domain\Transaction;
use WayForPay\SDK\Exception\ApiException;
use WayForPay\SDK\Request\ChargeRequest;
use WayForPay\SDK\Wizard\ChargeWizard;

// Use test credential or yours
$credential = new AccountSecretTestCredential();
//$credential = new AccountSecretCredential('account', 'secret');

try {
    $response = ChargeWizard::get($credential)
        ->setOrderReference(sha1(microtime(true)))
        ->setAmount(0.01)
        ->setCurrency('USD')
        ->setOrderDate(new \DateTime())
        ->setMerchantDomainName('https://google.com')
        ->setMerchantTransactionType(Transaction::MERCHANT_TRANSACTION_TYPE_SALE)
        ->setMerchantTransactionSecureType(ChargeRequest::MERCHANT_TRANSACTION_SECURE_TYPE_AUTO)
        ->setClient(new Client(
            'John',
            'Dou',
            'john.dou@gmail.com',
            '+12025550152',
            'USA'
        ))
        ->setProducts(new ProductCollection(array(
            new Product('test', 0.01, 1)
        )))
        ->setCard(new Card('5276999765600381', '05', '2021', '237', 'JOHN DOU'))
        //->setCardToken(new CardToken('1aa11aaa-1111-11aa-a1a1-0000a00a00aa'))
        ->getRequest()
        ->send();

    echo 'Status: ' . $response->getTransaction()->getStatus() . PHP_EOL;
} catch (ApiException $e) {
    echo "Exception: {$e->getMessage()}\n";
}