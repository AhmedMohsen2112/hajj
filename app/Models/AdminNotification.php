<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class AdminNotification extends MyModel {

    protected $table = 'admin_notifications';

    public function getCreatedAtAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public static function transform($item) {

        return $item;
    }

}
