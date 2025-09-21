<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\News;
use App\Models\Profile;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'position',
        'phone',
        'address',
        'photo',
        'is_active',
    ];
    
    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if (empty($this->photo)) {
            return null;
        }
        
        // If the photo path already contains 'storage/', don't add it again
        if (strpos($this->photo, 'storage/') === 0) {
            return asset($this->photo);
        }
        
        // If the photo path is a full URL, return it as is
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        
        // Default case: prepend 'storage/'
        return asset('storage/' . ltrim($this->photo, '/'));
    }
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
    
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'pengunjung',
        'is_active' => true,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the news articles for the user.
     */
    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Set default role when creating a new user
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'pengunjung';
            }
            
            // Ensure role is one of the allowed values
            if (!in_array($user->role, ['admin', 'pegawai', 'pengunjung'])) {
                $user->role = 'pengunjung';
            }
        });
    }

    /**
     * Get the profile for the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
