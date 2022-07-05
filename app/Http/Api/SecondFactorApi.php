<?php

namespace App\Http\Api;
use App\Http\Controllers\UserController;
require '../vendor/autoload.php';

class SecondFactorApi
{
    public function activate()
    {

        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData, true);

        $userController = new UserController();
        $res = $userController->activateSecondFactor($data['code'], $data['secret']);

        if ($res) {
            http_response_code(200);
        }else{
            http_response_code(400);
            echo 'Código Incorrecto.';
        }

    }


    public function desactivate()
    {
        $userController = new UserController();
        $userController->desactivateSecondFactor();
    }

    public function validate(){
        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData, true);

        $userController = new UserController();
        $res = $userController->validateTwoFactor($data['code']);

        if ($res) {
            http_response_code(200);
        }else{
            http_response_code(400);
            echo 'Código Incorrecto.';
        }
    }
}
