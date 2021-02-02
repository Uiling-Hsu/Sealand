<?php

namespace App\Model;

use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use HasRoleAndPermission;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
        'sort',
        'status',
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Model\Permission')->whereStatus(1)->withPivot('permission_id')->orderBy('sort');
    }
}
