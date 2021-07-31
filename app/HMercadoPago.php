<?php

include '../vendor/autoload.php';

function create_button()
{
    MercadoPago\SDK::setAccessToken("TEST-5598546372512178-021515-bfd9e67e24722569ea7640c6d9a48a11-209806929");
    MercadoPago\SDK::setClientId("5598546372512178");
    MercadoPago\SDK::setClientSecret("XCx6D7EgrlnOIT2SXSw5NYTVBDX1kpzu");

    
    $preference                     = new MercadoPago\Preference();

    

    $item                           = new MercadoPago\Item();
    $item->id                       = "00001";
    $item->title                    = "item";
    $item->quantity                 = 1;
    $item->unit_price               = 100;

    $preference->items              = array($item);

    $preference->payment_methods    = array(
        "excluded_payment_types" => array(
            array("id" => "bank_transfer")
        ),
        "installments" => 12
    );

    
    $token_user                     = csrf_token();
    $_SESSION['token_user']         = trim($token_user);

    $preference->back_urls          = array(
        "success" => url('/')."/pago-success?token=" . $token_user,
        "failure" => url('/')."/pago-failure?token=" . $token_user,
        "pending" => url('/')."/pago-ending?token=" . $token_user
    );

    $preference->auto_return        = "approved";

    $preference->save(); 


    $url_mercado_pago               = $preference->sandbox_init_point;
    return $url_mercado_pago;
}



function generate_token()
{
    return str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789" . uniqid());
}