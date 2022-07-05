<?php

namespace App\Http\Api;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
require '../vendor/autoload.php';

class LoginApi
{
    public function login(Request $request)
    {

        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData, true);

        $userController = new UserController();
        $res = $userController->login($data['email'], $data['password']);

        if ($res['result']) {
            http_response_code(200);
            echo json_encode($res);
        }else{
            http_response_code(400);
            echo 'No se puede iniciar sesion con esas credenciales.';
        }

    }
}
