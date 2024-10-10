<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'upwork-green': '#14a800',
                        'upwork-dark-green': '#108a00',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12 font-poppins">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="Company Logo" class="mx-auto mb-6 w-32">
            <h1 class="text-3xl font-semibold text-upwork-green mb-2">You're Almost There!</h1>
            <p class="text-gray-600 text-lg">Complete your registration and start earning today.</p>
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
            <h2 class="text-xl font-medium text-gray-800 mb-4">One Small Step for Your Career</h2>
            <p class="text-gray-600 mb-4">Activate your account with a small one-time fee of just <span
                    class="font-semibold text-upwork-green">KES 75</span>. This helps us maintain a high-quality
                platform for serious professionals like you.</p>
            <ul class="text-gray-600 list-disc list-inside space-y-2">
                <li>Instant access to high-paying writing jobs</li>
                <li>Connect with global clients</li>
                <li>Secure payment system</li>
                <li>24/7 support team</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('writer.process-payment') }}" class="space-y-6">
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
                Pay KES 75 via M-PESA
            </button>
        </form>

        <p class="mt-6 text-center text-gray-500 text-sm">
            By completing your registration, you agree to our <a href="#"
                class="text-upwork-green hover:underline">Terms of Service</a> and <a href="#"
                class="text-upwork-green hover:underline">Privacy Policy</a>.
        </p>
    </div>
</body>

</html>
