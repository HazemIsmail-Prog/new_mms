<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Korridor\LaravelHasManyMerged\HasManyMergedRelation;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasManyMergedRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function marketings()
    {
        return $this->hasMany(Marketing::class);
    }
    public function orders_technician()
    {
        return $this->hasMany(Order::class, 'technician_id');
    }

    public function orders_creator()
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->with('permissions');
    }

    public function permissions()
    {
        $permissionList = [];

        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if (!in_array($permission->id, $permissionList)) {
                    $permissionList[] = $permission->id;
                }
            }
        }

        return $permissionList;
    }

    public function hasPermission($permission)
    {
        if ($this->permissions()) {
            if (in_array($permission, $this->permissions())) {
                return true;
            }
        }

        return false;
    }

    public function getNameAttribute($value)
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar ?? $this->name_en;
        } else {
            return $this->name_en ?? $this->name_ar;
        }
    }

    public function messages()
    {
        return $this->hasManyMerged(Message::class, ['sender_user_id', 'receiver_user_id']);
    }

    public function getCurrentOrderForTechnicianAttribute()
    {
        return $this->orders_technician()
            ->whereIn('status_id', [2, 3, 7])
            ->orderBy('index')
            ->with('invoices.payments')
            ->first();
    }
}
