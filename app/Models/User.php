<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles ;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'whatsapp',   
        'instansi',   
        'pekerjaan',  
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
    public function subMaterisSelesai()
    {
        return $this->belongsToMany(SubMateri::class, 'sub_materi_user')
                    ->withTimestamps();
    }

    /**
     * Menghitung persentase progres untuk satu Materi Utama
     */
    public function progressMateri($ruangMateriId)
    {
        // 1. Hitung total bab yang ada di materi ini
        $totalBab = \App\Models\SubMateri::where('ruang_materi_id', $ruangMateriId)->count();
        
        if ($totalBab == 0) return 0;

        // 2. Hitung berapa bab yang sudah diselesaikan oleh user ini di materi tersebut
        $babSelesai = $this->subMaterisSelesai()
                        ->where('ruang_materi_id', $ruangMateriId)
                        ->count();

        // 3. Kembalikan hasil dalam persen
        return round(($babSelesai / $totalBab) * 100);
    }
}
