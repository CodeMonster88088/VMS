<p>Dear {{ Auth::user()->name }},</p>
<p>Your One-Time Password (OTP) is:</p>
<h2>{{ $otp }}</h2>
<p>This OTP will expire in 10 minutes.</p>
<p>Thank you.</p>
