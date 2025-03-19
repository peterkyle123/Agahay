<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    // Display a listing of payment methods for admin
    public function index()
    {
        if (!session()->has('admin')) {
            return redirect()->route('adminlogin'); // Redirects to login page if no session
        }
        $paymentMethods = PaymentMethod::all();
        return view('payment_methods.index', compact('paymentMethods'));
    }

    // Show the form for creating a new payment method
    public function create()
    {
        return view('payment_methods.create');
    }

    // Store a newly created payment method in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
            'qr_code_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // New rule for QR code image
        ]);

        // Handle the QR code image upload if exists
        if ($request->hasFile('qr_code_image')) {
            $qrImagePath = $request->file('qr_code_image')->store('payment_qr_codes', 'public');
            $validated['qr_code_image'] = $qrImagePath;
        }

        PaymentMethod::create($validated);

        return redirect()->route('payment_methods.index')->with('success', 'Payment method created successfully!');
    }

    // Show the form for editing the specified payment method
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    // Update the specified payment method in storage
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
            'qr_code_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000', // New rule for QR code image
        ]);

        // Handle the QR code image upload if exists
        if ($request->hasFile('qr_code_image')) {
            $qrImagePath = $request->file('qr_code_image')->store('payment_qr_codes', 'public');
            $validated['qr_code_image'] = $qrImagePath;
        }

        $paymentMethod->update($validated);

        return redirect()->route('payment_methods.index')->with('success', 'Payment method updated successfully!');
    }

    // Remove the specified payment method from storage
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('payment_methods.index')->with('success', 'Payment method deleted successfully!');
    }

    // Toggle display status of the payment method
    public function toggleDisplay(PaymentMethod $paymentMethod)
    {
        $paymentMethod->update(['display' => !$paymentMethod->display]);
        return redirect()->route('payment_methods.index')->with('success', 'Payment method display status updated!');
    }
}
