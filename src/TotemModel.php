<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 11/13/17
 * Time: 2:18 PM
 */

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class TotemModel extends Model
{
    /**
     * @return mixed
     */
    public function getTable()
    {
        return config('totem.table_prefix') . parent::getTable();
    }
}