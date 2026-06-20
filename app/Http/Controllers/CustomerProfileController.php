<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('customer/profile', [
            'customer' => $request->user()->customer,
            'status' => $request->session()->get('status'),
        ]);
    }

    public function update(CustomerProfileRequest $request): RedirectResponse
    {
        $request->user()->customer()->updateOrCreate(
            [],
            $request->validated(),
        );

        return redirect()
            ->route('dashboard')
            ->with('status', 'customer-profile-saved');
    }

    public function skip(): RedirectResponse
    {
        return redirect()
            ->route('dashboard')
            ->with('status', 'customer-profile-skipped');
    }
}
