<?php
require_once('vendor/autoload.php');

$stripe = array(
//  "secret_key"      => "sk_test_0i90knoyXFUWHH9HlomsmLVY",
//  "publishable_key" => "pk_test_OCv6gFYYvqivyUsJDshdLbLi"
    "secret_key"      => "sk_live_p8sc2w5D0dpogqnbW1hWwS3g",
    "publishable_key" => "pk_live_ZRdylhBSJr7ocryqDpMhH8ie"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
