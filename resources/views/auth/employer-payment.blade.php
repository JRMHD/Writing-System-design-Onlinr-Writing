<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Employer Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'upwork-green': '#14a800',
                        'upwork-dark-green': '#108a00',
                        'light-gray': '#f7f7f7',
                        'text-gray': '#5e6d55',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-light-gray min-h-screen flex items-center justify-center py-12 font-poppins">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Company Logo" class="mx-auto mb-6 w-32">
            <h1 class="text-3xl font-semibold text-upwork-green">Unlock Your Hiring Potential</h1>
            <p class="text-text-gray mt-2 text-lg">One small step to access top-tier talent</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4">Why Activate Your Account?</h2>
            <ul class="text-text-gray list-disc list-inside space-y-2">
                <li>Access to a pool of pre-vetted, skilled writers</li>
                <li>Post jobs and receive quality applications within hours</li>
                <li>Secure escrow payment system</li>
                <li>Dedicated support for employers</li>
                <li>No long-term contracts - pay only when you hire</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('employer.process-payment') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $verification->token }}">
            <!-- Placeholder for MPESA STK push -->
            <button type="submit"
                class="w-full bg-upwork-green text-white py-3 rounded-md hover:bg-upwork-dark-green transition duration-300 transform hover:scale-105 text-lg font-semibold flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Activate Account - Pay KES 100 via M-PESA
            </button>
        </form>

        <p class="mt-6 text-center text-text-gray">
            Your account will be instantly activated after payment.
        </p>

        <p class="mt-4 text-center text-sm text-gray-500">
            By activating your account, you agree to our <a href="#"
                class="text-upwork-green hover:underline">Terms of Service</a> and <a href="#"
                class="text-upwork-green hover:underline">Privacy Policy</a>.
        </p>
    </div>
</body>

</html>
