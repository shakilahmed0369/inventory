<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customers = Customer::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        Customer::create($request->validated());

        notyf()->success('Customer created successfully.');

        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        notyf()->success('Customer updated successfully.');

        return redirect()->route('customers.index');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        notyf()->success('Customer deleted.');

        return redirect()->route('customers.index');
    }
}
