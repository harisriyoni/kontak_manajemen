<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
{
    use HasFactory;

    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'username',
        'password',
        'name',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contacts::class, 'user_id', 'id');
    }
    public function getAuthIdentifierName()
    {
        // intinya dia ingin tau id atau identifier untuk user itu apa
        // id kita kita pakai username
        return 'username';
    }
    public function getAuthIdentifier()
    {
        // nah disini pengen tau siapa user nya yang login
        return $this->username;
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getRememberToken()
    {
        $this->token;
    }
    public function setRememberToken($value)
    {
        $this->token = $value;
    }
    public function getRememberTokenName()
    {
        return 'token';
    }
}
