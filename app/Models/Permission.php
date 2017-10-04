<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/22
 * Time: 15:38
 */

namespace App\Models;


use App\Traits\Model\BaseModel as traitModel;
use Zizaco\Entrust\EntrustPermission;
class Permission extends EntrustPermission
{
    use traitModel;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'component',
        'redirect',
        'is_menu',
        'icon',
        'meta',
        'noDropdown',
        'description',
        'pid',
        'sort'
    ];




}