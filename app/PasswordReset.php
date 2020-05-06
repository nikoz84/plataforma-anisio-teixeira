<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserCan;

class PasswordReset extends Model
{
	protected $table = "password_resets";

	public $timestamps = false;
	protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    public function getTokenByEmail($email)
    {
    	return $this->where('email', $email)->first();
    }
}