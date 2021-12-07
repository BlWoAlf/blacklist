<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public function blacklistAdvertiser()
    {
        return $this->morphToMany(Advertiser::class, 'blacklistable', 'blacklists', 'blacklistable_id', 'advertiser_id');
    }
}
