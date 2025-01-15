<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GetRoleModel extends Model
{
    protected $table = 'authentications';
    protected $primaryKey = 'authentication_id';
    public $timestamps = true;

    /**
     * Get the authorization role by authentication_id
     *
     * @param  int  $aid
     * @return string|null
     */
    public static function getRoleByAID($aid)
    {
        return DB::table('authorizations as az')
            ->join('authentications as a', 'a.authorization_id', '=', 'az.authorization_id')
            ->where('a.authentication_id', $aid)
            ->value('az.authorization_role');
    }
}
