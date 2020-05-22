<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jarbas\Routes\Facades\Uello;

class CustomersRepository extends Repository implements CustomersRepositoryInterface
{
    public function import(string $fileName): bool
    {
        if (!Storage::exists($fileName)) {
            return false;
        }

        // Split whole content by row
        $row = explode(PHP_EOL, Storage::get($fileName));

        $header  = [];
        $data = collect();

        // Each line
        foreach ($row as $k => $v) {
            if ($k == 0) {
                continue;
            }

            // Split line        
            list($name, $email, $birthDate, $cpf, $address, $zipCode) = explode(';', $v);

            $address = Uello::getFullAddress($address);

            $data->push([
                'name' => $name,
                'email' => $email,
                'birth_date' => $birthDate,
                'cpf' => $cpf,
                'address' => $address['address'],
                'city' => $address['city'],
                'number' => $address['number'],
                'neighborhood' => $address['neighborhood'],
                'state' => $address['state'],
                'zip_code' => $zipCode,
                'lat' => $address['lat'],
                'lng' => $address['lng'],
                'place_id' => $address['place_id'],
            ]);
        }

        $data->each(function ($line) {
            try {
                $this->model->create($line);
            } catch (\Throwable $th) {
                // TODO: Catch for wrong items

                // report($th);
            }
        });

        return true;
    }

    public function getAddressesByOptimizedOrder(array $orderedIds): Collection
    {
        $ids = implode(',', $orderedIds);
        
        return $this->model::whereIn('id', $orderedIds)
            ->orderByRaw("FIELD(id, {$ids})")
            ->get();
    }
}
