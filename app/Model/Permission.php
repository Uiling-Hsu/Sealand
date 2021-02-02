<?php

namespace App\Model;

use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasRoleAndPermission;

        protected $fillable = [
            'name',
            'slug',
            'description',
            'model',
            'sort',
            'status',
        ];
}