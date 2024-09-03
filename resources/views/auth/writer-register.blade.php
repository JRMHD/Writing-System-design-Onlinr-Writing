<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'deep-orange': '#FF5722',
                        'royal-blue': '#4169E1',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="mx-auto w-32 h-auto mb-4">
            <h1 class="text-3xl font-bold text-deep-orange">Writer Registration</h1>
            <p class="text-gray-600 mt-2">Create your writer account</p>
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

        <form method="POST" action="{{ route('writer.register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your Full Name" required
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-deep-orange transition duration-300">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-deep-orange transition duration-300">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Your phone number" required
                    value="{{ old('phone') }}"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-deep-orange transition duration-300">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-deep-orange transition duration-300">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-deep-orange transition duration-300">
            </div>
            <button type="submit"
                class="w-full bg-deep-orange text-white py-2 rounded-md hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Register
            </button>
        </form>

        <p class="mt-6 text-center text-gray-600">
            Already have an account?
            <a href="{{ route('writer.login') }}" class="text-royal-blue hover:underline transition duration-300">Login
                here</a>
        </p>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>By registering, you agree to our</p>
            <a href="#" class="text-deep-orange hover:underline transition duration-300">Terms of Service</a> and
            <a href="#" class="text-deep-orange hover:underline transition duration-300">Privacy Policy</a>
        </div>
    </div>
</body>

</html>
