@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 px-8 py-10 w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-100 rounded-full mb-4">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">Become an Editor</h2>
            <p class="text-sm text-gray-500 mt-1">Enter your phone number to receive a verification code</p>
        </div>

        <!-- Form -->
        <form method="POST" action="/send-otp" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
                <input 
                    type="text" 
                    name="phone" 
                    placeholder="XX XXX XXX"
                    class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button 
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-xl text-sm transition-colors duration-150">
                Send OTP
            </button>

        </form>

    </div>
</div>

@endsection