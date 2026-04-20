<h2>Verify OTP</h2>

<form method="POST" action="/verify-otp">
    @csrf

    <input type="text" name="phone" value="{{ session('phone') }}" readonly>

    <input type="text" name="code" placeholder="Enter code">

    <button type="submit">Verify</button>
</form>