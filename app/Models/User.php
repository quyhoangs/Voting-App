<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

        public function getAvatar()
        {
            //xử lý avt theo gravatar hiển thị random và cố định nó theo email của user
            //0-9 => 1
            //a-z => 1-26

            //1.Lấy ký tự đầu tiên của email
            $firstCharacter = $this->email[0];

            if (is_numeric($firstCharacter)) {
                //2. Chuyển ký tự thành một số, sử dụng ord ()
                //3. Lấy số trừ đi 21 (nếu ký tự đầu tiên là một số)
                $integerToUse = ord(strtolower($firstCharacter)) - 21;
            } else {
                //4. Lấy số trừ đi 96 (nếu ký tự đầu tiên là một chữ cái)
                $integerToUse = ord(strtolower($firstCharacter)) - 96;
            }
            //Gravatar Hash theo email của user để lấy avt
            return 'https://www.gravatar.com/avatar/'
                .md5($this->email)
                .'?s=200'
                .'&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-'
                .$integerToUse
                .'.png';
        }
}
