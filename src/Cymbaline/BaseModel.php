<?php

namespace Cymbaline;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static $get_all_enabled = true;
    public static $create_enabled = true;
    public static $get_enabled = true;
    public static $delete_enabled = true;
    public static $update_enabled = true;
}