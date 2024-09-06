<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Register</title>
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
            <h1 class="text-2xl font-semibold text-upwork-green">Employer Registration</h1>
            <p class="text-text-gray mt-2">Create your employer account</p>
        </div>

        @if (session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <ul class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('employer.register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-dark-gray mb-1">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your Full Name" required
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-dark-gray mb-1">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-dark-gray mb-1">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Your phone number" required
                    value="{{ old('phone') }}"
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-dark-gray mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-dark-gray mb-1">Confirm
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    required
                    class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-upwork-green transition duration-300">
            </div>
            <button type="submit"
                class="w-full bg-upwork-green text-white py-2 rounded-md hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Register
            </button>
        </form>

        <p class="mt-6 text-center text-text-gray">
            Already have an account?
            <a href="{{ route('employer.login') }}"
                class="text-upwork-green hover:underline transition duration-300">Login here</a>
        </p>

        <div class="mt-8 text-center text-sm text-text-gray">
            <p>By registering, you agree to our</p>
            <a href="#" class="text-upwork-green hover:underline transition duration-300">Terms of Service</a> and
            <a href="#" class="text-upwork-green hover:underline transition duration-300">Privacy Policy</a>
        </div>
    </div>
</body>

</html>
