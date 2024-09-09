<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // يمكنك استخدام هذا إذا كنت تحتاج إلى التحقق من البريد الإلكتروني
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // واجهة JWTSubject

class User extends Authenticatable implements JWTSubject // تطبيق واجهة JWTSubject
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    /*
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /*
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    // حماية كلمة المرور من التعيين 
    protected $guarded = ['password'];

    // تمكين تتبع أوقات إنشاء وتحديث السجلات
    public $timestamps = true;

    /*
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // إرجاع المفتاح الأساسي للمستخدم
    }

    /*
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // يمكنك إضافة معلومات إضافية إلى الـ JWT هنا
    }

}
