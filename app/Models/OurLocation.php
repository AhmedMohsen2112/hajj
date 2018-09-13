<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurLocation extends MyModel {

    protected $table = "our_locations";

    public static function transform($item) {
        $lang_code = static::getLangCode();
        $transformer = new \stdClass();
        $transformer->id = $item->id;
        $transformer->location_image = url('public/uploads/our_locations') . '/' . $item->location_image;
        $transformer->title = $item->title;
        $transformer->address = getAddress($item->lat, $item->lng, strtoupper($lang_code));
        $transformer->lat = $item->lat;
        $transformer->lng = $item->lng;
        $transformer->contact_numbers = explode(",", $item->contact_numbers);

        return $transformer;
    }

}
