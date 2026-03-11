<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laratrust\Traits\LaratrustPermissionTrait;

class Permission extends Model
{
    use LaratrustPermissionTrait;
}
