<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class BlacklistParser
{
    public static function getEntitiesIdFromString($blacklist)
    {
        $entity_list = [];
        $blacklist_array = Str::of($blacklist)->explode(', ');

        foreach ($blacklist_array as $entity){
            $entity = Str::of($entity)->ltrim(' ');
            if(Str::of($entity)->match('/^[A-z][1-9][0-9]*/') == $entity){
                $entity_item['id'] = Str::of($entity)->substr(1)->__toString();
                $entity_item['type'] = Str::of($entity)->substr(0,1)->__toString();
                $entity_list[] = $entity_item;
            }
        }
        return $entity_list;
    }

    public static function getStringFromArray($array)
    {
        $blacklist = [];

        foreach ($array as $entity){
            $blacklist[] = $entity['type'].$entity['id'];
        }

        $blacklist_string = implode(', ', $blacklist);
        return $blacklist_string;
    }
}
