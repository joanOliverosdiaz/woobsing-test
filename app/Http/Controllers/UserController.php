<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class UserController extends Controller
{
    use Traits\UserTrait;
    /**
     * Method: Metodo para registrar usuarios
     */
    public function register($name, $email, $password)
    {
        $id = (new User())->createUser($name, $email, $password);
        return $id;
    }

    /**
     * Method: Metodo para iniciar sesion
     */
    public function login($email, $password)
    {
        $user = (new User())->getUser($email);

        if (is_null($user)) {
            return ['result' => false];
        }

        if (!password_verify($password, $user['password'])) {
            return ['result' => false];
        }

        //TODO : Segundo factor de autenticacion

        if (!is_null($user['two_factor'])) {
            $this->createSession(null, $user['email'], false);
            return ['result' => true, 'secondFactor' => true];
        }

        $this->createSession($user['id'], $user['email']);
        return ['result' => true, 'secondFactor' => false];
    }

    public function logout()
    {
        if (!isset($_SESSION)) {
            if (!isset($_SESSION)) {
                session_start();
            }
        }

        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['isLoggedIn']);

        return redirect('/login');
    }

    public function activateSecondFactor($code, $secret)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if ($this->checkGoogleAuthCode($code, $secret)) {
            (new User())->createSecret($secret, $_SESSION['id']);
            return true;
        }
        return false;
    }

    public function desactivateSecondFactor()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        (new User())->deleteSecret($_SESSION['id']);
    }


    public function validateTwoFactor(string $code)
    {
        $user = $this->getUser();
        if ($this->checkGoogleAuthCode($code, $user['two_factor'])) {
            $this->createSession($user['id'], $user['email']);
            return true;
        }
        return false;
    }

    public function twoFactorAuth(Request $request)
    {
        $user = $this->getUser();
        $isActiveTwoFactor = true;

        if (is_null($user['two_factor'])) {
            $isActiveTwoFactor = false;
        }
        $google2fa = new Google2FA();
        $email = $_SESSION['email'];

        $registration_data[
            'google2fa_secret'
        ] = (new Google2FA())->generateSecretKey();

        $qrCode = $google2fa->getQRCodeUrl(
            config('app.name'),
            $email,
            $registration_data['google2fa_secret']
        );

        return view('auth.twoFactor', [
            'QR_Image' => $qrCode,
            'isActiveTwoFactor' => $isActiveTwoFactor,
            'google2fa_secret' => $registration_data['google2fa_secret'],
        ]);
    }
}
