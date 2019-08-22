<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->paginate(Config('variables.paginate'));
        $data = ['customers' => $customers];
        return view('admin.customer.index', $data);
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $customer = $request->all();
        $customer['password'] = \Hash::make($request->password);
        Customer::create($customer);
        return redirect()->route('customers.index')->with('message', __('messages.create_message'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $data = [ 'customer' => $customer ];
        return view('admin.customer.update', $data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}