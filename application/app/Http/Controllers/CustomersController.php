<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\StoreCustomersRequest;
use App\Repository\CustomersRepository;
use Jarbas\Routes\Facades\Uello;

class CustomersController extends Controller
{
    protected $customersRespository;

    public function __construct(Customer $customerModel)
    {
        $this->customersRespository = new CustomersRepository($customerModel);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allAddresses = $this->customersRespository->all();

        /**
         * Get an optimized order based on Google Directions API,
         * using the 'optimized' option for waypoints.
         */
        $order = Uello::getBestRoutes($allAddresses);

        /**
         * After, get on database records with the optimized order
         */
        $customers = $this->customersRespository->getAddressesByOptimizedOrder($order);

        return view('optimized', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('import');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomersRequest $request)
    {
        $file = $request->file('csv');
        $file = $file->store('/');

        $this->customersRespository->import($file);

        return redirect('/');
    }

    public function export()
    {
        $allAddresses = $this->customersRespository->all()->toArray();

        array_unshift($allAddresses, array_keys($allAddresses[0]));

        return response()->stream(
            function () use ($allAddresses) {
                $fp = fopen('php://output', 'w');

                foreach ($allAddresses as $k => $v) {
                    fputcsv($fp, $v, ';');
                }

                fclose($fp);
            },
            200,
            [
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=dados.csv',
            ]
        );
    }
}
