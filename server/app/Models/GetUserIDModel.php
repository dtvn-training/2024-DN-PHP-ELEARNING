<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GetUserIDModel extends Model
{
    protected $table = 'authentications';
    protected $primaryKey = 'authentication_id';

    /**
     * Get the authorization role by authentication_id
     *
     * @param  int  $aid
     * @return string|null
     */
    public static function execute($aid): ?int
    {
        return DB::table('users as u')
            ->join('authentications as a', 'a.authentication_id', '=', 'u.authentication_id')
            ->where('a.authentication_id', $aid)
            ->value('u.user_id');
    }
}
