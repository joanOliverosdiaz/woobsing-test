<?php

namespace App\Http\Controllers\Traits;

trait UserTrait
{
    /**
     * Method: Metodo para almacenar la sesion
     */

    protected function createSession($id, $email, $isLoggedIn = true)
    {
        if (!isset($_SESSION)) {
            if (!isset($_SESSION)) {
                session_start();
            }
        }
        $_SESSION['isLoggedIn'] = $isLoggedIn;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;
    }

    /**
     * Method: Validar si el usuario esta logueado
     */
    public function isUserLogedIn()
    {
        return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'];
    }

    /**
     * Method : Obtener la información del usuario
     */
    public function getUser()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return (new User())->getUser($_SESSION['email']);
    }

    public function checkGoogleAuthCode($code, $secret)
    {
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($secret, $code)) {
            return true;
        }
        return false;
    }
}
