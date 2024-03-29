<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index()
    {

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $customerLogin = Auth::user();
        if ($customerLogin->can('update', $customer)) {
            $data = [
                'customer' => $customer,
            ];
            return view('customer.update', $data);
        } else {
            return abort('401');
        }
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return redirect()->route('customer-projects.index')->with('message', __('messages.update_message'));
    }

    public function destroy($id)
    {

    }
}
