<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['created_at', 'updated_at'];

    public function form(): HasOne
    {
        return $this->hasOne(Form::class, "user_id", "id");
    }

    public function medias(): HasMany
    {
        return $this->hasMany(UserMedia::class, "user_id", "id");
    }

    public function isFormFilled()
    {
        if(isset($this->form)) {
            foreach ($this->form->toArray() as $field => $value) {
                if($field != 'number') {
                    if ($value === null) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function mediasCount($type = "photo"): Int
    {
        return $this->medias()->where("type", "=", $type)->count();
    }

}
