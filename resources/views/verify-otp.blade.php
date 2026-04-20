@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 px-8 py-10 w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-green-100 rounded-full mb-4">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">Verify OTP</h2>
            <p class="text-sm text-gray-500 mt-1">Enter the code sent to your phone</p>
        </div>

        <!-- Errors -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-6">
                @foreach ($errors->all() as $error)
                    <p class="text-red-600 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="/verify-otp" class="space-y-4">
            @csrf

            <!-- Phone (readonly) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
                <input 
                    type="text"
                    name="phone"
                    value="{{ session('phone') }}"
                    readonly
                    class="w-full border border-gray-200 bg-gray-100 rounded-xl px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed"
                >
            </div>

            <!-- OTP Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OTP Code</label>
                <input 
                    type="text"
                    name="code"
                    placeholder="Enter OTP code"
                    maxlength="6"
                    class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm tracking-widest text-center font-mono focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 rounded-xl text-sm transition-colors duration-150">
                Verify Code
            </button>

        </form>

        <!-- Back link -->
        <p class="text-center text-sm text-gray-400 mt-6">
            Didn't receive the code?
            <a href="/become-editor" class="text-indigo-600 hover:underline ml-1">Resend</a>
        </p>

    </div>
</div>

@endsection