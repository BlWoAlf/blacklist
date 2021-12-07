<?php

namespace App\Models;

use App\Helpers\BlacklistParser;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    public static function saveBlacklist($blacklist, $advertiser_id)
    {
        $advertiser = Advertiser::find($advertiser_id);
        $blacklist_collection = BlacklistParser::getEntitiesIdFromString($blacklist);

        if ($advertiser === null){
            return null;
        }

        foreach ($blacklist_collection as $blacklist_entity){
            if('p' === $blacklist_entity['type']){
                $entity = Publisher::find($blacklist_entity['id']);
                if($entity != null){
                    $advertiser->blacklistPublishers()->syncWithoutDetaching($blacklist_entity['id']);
                }
            }
            else if('s' === $blacklist_entity['type']){
                $entity = Site::find($blacklist_entity['id']);
                if($entity != null){
                    $advertiser->blacklistSites()->syncWithoutDetaching($blacklist_entity['id']);
                }
            }
        }

        return true;
    }

    public static function getBlacklist($advertiser_id)
    {
        $entity_list = [];
        $advertiser = Advertiser::find($advertiser_id);

        if ($advertiser === null){
            return null;
        }

        $blacklist_collection = self::where('advertiser_id', $advertiser_id)->get();

        foreach ($blacklist_collection as $entity){
            if($entity->blacklistable_type === 'App\Models\Publisher'){
                $entity_type = 'p';
            }
            else if ($entity->blacklistable_type === 'App\Models\Site'){
                $entity_type = 's';
            }
            $entity_list[] = ['id' => $entity->blacklistable_id, 'type' => $entity_type];
        }

        $blacklist = BlacklistParser::getStringFromArray($entity_list);

        return $blacklist;
    }
}
