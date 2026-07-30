<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the marksheets for the student.
     */
    public function marksheets(): HasMany
    {
        return $this->hasMany(Marksheet::class, 'student_id');
    }

    /**
     * Get the marksheets created by this teacher/principal.
     */
    public function createdMarksheets(): HasMany
    {
        return $this->hasMany(Marksheet::class, 'created_by');
    }

    /**
     * Get the certificates for the student.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }

    /**
     * Get the certificates created by this teacher/principal.
     */
    public function createdCertificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'created_by');
    }

    /**
     * Get the news articles authored by the user.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
