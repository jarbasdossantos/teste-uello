<?php

namespace Jarbas\Routes;

use GoogleMaps\Facade\GoogleMapsFacade as GoogleMaps;
use Illuminate\Database\Eloquent\Collection;

class Uello
{
    private $originPlaceId = 'ChIJPW-bvLf4zpQRwIARaSxc-mM';

    protected $addresses;

    public function __construct()
    {
        $this->routes = collect();
    }

    public function getFullAddress(string $addressLine): array
    {
        $geocoderGetAddress = new GeocodeGetAddress($addressLine);
        $parsedAddress = $geocoderGetAddress->getAddressOnAPI();

        if ($parsedAddress) {
            return [
                'address' => $parsedAddress['street'],
                'city' => $parsedAddress['city'],
                'number' => $parsedAddress['number'],
                'neighborhood' => $parsedAddress['neighborhood'],
                'state' => $parsedAddress['state'],
                'lat' => $parsedAddress['lat'],
                'lng' => $parsedAddress['lng'],
                'place_id' => $parsedAddress['place_id']
            ];
        }

        return [];
    }

    public function getBestRoutes(Collection $addresses): array
    {
        $this->addresses = $addresses;

        $order = [];

        $destination = null;
        $wayPoints = [
            0 => 'optimize:true'
        ];

        foreach ($this->addresses as $k => $v) {
            if ($k == 0) {
                $destination = $v->place_id;
            }

            $order[] = $v->id;

            $wayPoints[] = [
                'location' => "place_id:{$v->place_id}",
                'stopover' => false
            ];
        }

        $json = GoogleMaps::load('directions')
            ->setParam([
                'origin' => "place_id:{$this->originPlaceId}",
                'destination' => "place_id:{$destination}",
                'waypoints' => $wayPoints,
                'optimize' => true
            ])
            ->get();

        $data = json_decode($json);

        $optimizedOrder = $data->routes[0]->waypoint_order;

        uksort($order, function ($key1, $key2) use ($optimizedOrder) {
            return (array_search($key1, $optimizedOrder) > array_search($key2, $optimizedOrder));
        });

        return $order;
    }
}
