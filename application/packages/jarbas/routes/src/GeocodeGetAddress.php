<?php

namespace Jarbas\Routes;

use GoogleMaps\Facade\GoogleMapsFacade as GoogleMaps;

/**
 * 
 * CAUTION!!!!
 * 
 * HARDCODE BELOW :/
 */
final class GeocodeGetAddress
{
    protected $rawAddress;
    protected $parsed = [];

    public function __construct(string $addressLine)
    {
        $this->rawAddress = $addressLine;
    }

    public function getAddressOnAPI()
    {
        // Get lat and long
        $json = GoogleMaps::load('geocoding')
            ->setParam([
                'address' => $this->rawAddress
            ])
            ->get();

        $data = json_decode($json);

        if ($data->status !== 'OK') {
            return false;
        }

        $result = $data->results;

        $this->parseAddressComponents($result);

        if (count($this->parsed)) {
            $this->parsed['lat'] = $result[0]->geometry->location->lat;
            $this->parsed['lng'] = $result[0]->geometry->location->lng;

            return $this->parsed;
        }

        return false;
    }

    protected function parseAddressComponents(array $data)
    {
        $this->parsed['place_id'] = $data[0]->place_id;
        
        foreach ($data[0]->address_components as $k => $v) {
            $v = (array) $v;
            $types = $v['types'];

            if (in_array('route', $types)) {
                $this->parsed['street'] = $v['long_name'];
            }

            if (in_array('street_number', $types)) {
                $this->parsed['number'] = $v['long_name'];
            }

            if (in_array('long_name', $types)) {
                $this->parsed['street_number'] = $v['long_name'];
            }

            if (in_array('political', $types) and in_array('sublocality', $types)) {
                $this->parsed['neighborhood'] = $v['long_name'];
            }

            if (in_array('administrative_area_level_2', $types)) {
                $this->parsed['city'] = $v['long_name'];
            }

            if (in_array('administrative_area_level_1', $types)) {
                $this->parsed['state'] = $v['short_name'];
            }
        }
    }
}
