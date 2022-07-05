<?php


namespace App\Http\Api;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
require '../vendor/autoload.php';

class RegisterUserApi
{
    public function register(Request $request)
    {
        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData, true);

        $userController = new UserController();

        $id = $userController->register(
            $data['name'],
            $data['email'],
            $data['password']
        ); //TODO: Registrar usuario

        if ($id === 0) {
            http_response_code(400);
            echo 'Ya existe un usuario registrado con ese email';
        }else{
            http_response_code(200);
            $userController->login($data['email'], $data['password']);
            return $id;
        }


    }
}
