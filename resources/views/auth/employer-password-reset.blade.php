<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Password Reset</title>
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
            <p class="text-text-gray mt-2">Enter your new password below.</p>
        </div>

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('employer.password.update') }}" class="space-y-4">
            @csrf
            <!-- Include token and email as hidden fields -->
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="password" class="block text-sm font-medium text-dark-gray mb-1">New Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-dark-gray mb-1">Confirm New
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    required
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <button type="submit"
                class="w-full bg-upwork-green text-white py-2 rounded-md hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Reset Password
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
