<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    public function blacklistPublishers()
    {
        return $this->morphedByMany(Publisher::class, 'blacklistable', 'blacklists', 'advertiser_id', 'blacklistable_id');
    }

    public function blacklistSites()
    {
        return $this->morphedByMany(Site::class,'blacklistable', 'blacklists','advertiser_id', 'blacklistable_id');
    }
}
