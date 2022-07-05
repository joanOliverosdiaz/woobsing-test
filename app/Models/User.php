<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Database
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function createUser($name, $email, $password)
    {
        $query = $this->db->prepare("INSERT INTO usuarios (name, email, password) VALUES (?, ? ,? )");
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query->bind_param('sss', $name, $email, $hash);
        $query->execute();
        $insertedId = $query->insert_id;
        $query->close();
        return $insertedId;
    }

    public function getUser( $email)
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        return $result->fetch_assoc();
    }

    public function createSecret($secret, $id)
    {
        $query = $this->db->prepare("UPDATE usuarios SET two_factor = ? WHERE id = ?");
        $query->bind_param('si', $secret, $id);
        $query->execute();
        $query->close();
    }


    public function deleteSecret($id)
    {
        $query = $this->db->prepare("UPDATE usuarios SET two_factor = null WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $query->close();
    }
}
