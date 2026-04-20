<h2>Enter Your Phone Number</h2>

<form method="POST" action="/send-otp">
    @csrf

    <input type="text" name="phone" placeholder="Phone number"
           class="border p-2">

    <button type="submit" class="bg-blue-500 text-white px-4 py-2">
        Send Code
    </button>

    
</form>