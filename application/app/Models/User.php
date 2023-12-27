<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const DEFAULT_AVATAR='avatars/default-avatar.jpg';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (string $password) => $password,
            set: fn (string $password) => bcrypt($password),
        );
    }

//    protected function avatar(): Attribute
//    {
//        return Attribute::make(
//            get: fn(UploadedFile $file, $attributes) => $attributes['avatar'],
//
//            set: function (UploadedFile $file) {
//
//                //проверяем нет ли у данного экземпляра модели Post значения у атрибута image, если есть удаляем его
//                if (key_exists('avatar',$this->attributes) && $this->attributes['avatar'] != null) {
//                    Storage::delete('avatars/', $this->attributes['avatar']);
//                }
//
//                //сохраняем изображение в папке uploads и устанавливаем (новое) значение атрибута
//                if ($file != null) {
//                    $filename = uniqid(more_entropy: true) . '.' . $file->extension();
//                    $file->storeAs('avatars/', $filename);
//
//                    $this->attributes['avatar'] = $filename;
//
//                } else {
//                    $this->attributes['avatar']= User::DEFAULT_AVATAR;
//                }
//            },
//        );
//    }

}
