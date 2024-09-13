<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Password Reset Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'upwork-green': '#3CBE5C',
                        'dark-gray': '#4A4A4A',
                        'light-gray': '#F5F5F5',
                        'text-gray': '#6D6E71'
                    },
                    fontFamily: {
                        'body': ['Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-light-gray min-h-screen flex items-center justify-center py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="mx-auto w-32 h-auto mb-4">
            <h1 class="text-2xl font-semibold text-upwork-green">Reset Your Password</h1>
            <p class="text-text-gray mt-2">Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>

        @if (session('status'))
            <p class="text-green-600 mb-4">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('employer.password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-dark-gray mb-1">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <button type="submit"
                class="w-full bg-upwork-green text-white py-2 rounded-md hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Send Password Reset Link
            </button>
        </form>

        <p class="mt-6 text-center text-text-gray">
            Remembered your password?
            <a href="{{ route('employer.login') }}"
                class="text-upwork-green hover:underline transition duration-300">Login here</a>
        </p>
    </div>
</body>

</html>
