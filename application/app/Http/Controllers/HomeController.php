<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Repository\CustomersRepository;

class HomeController extends Controller
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
        $customers = $this->customersRespository->all();

        return view('home', compact('customers'));
    }
}
