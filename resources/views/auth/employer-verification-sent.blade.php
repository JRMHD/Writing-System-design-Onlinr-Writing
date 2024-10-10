<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Email Sent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'upwork-green': '#14a800',
                        'upwork-light-green': '#1cbe07',
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
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <img src="/images/logo.png" alt="Company Logo" class="mx-auto mb-8 w-48">
        <h1 class="text-5xl font-semibold text-upwork-green mb-6">Success!</h1>
        <h2 class="text-2xl font-medium text-gray-800 mb-4">You're almost there</h2>
        <p class="text-lg text-gray-600 mb-6">We've sent a verification email to your inbox. Please check and follow the
            instructions to complete your registration.</p>
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <p class="text-sm text-gray-500">Didn't receive the email? Check your spam folder or</p>
            <a href="/employer/register/" class="text-upwork-green hover:text-upwork-light-green font-medium">Request a
                new
                verification email</a>
        </div>
        <a href="/"
            class="bg-upwork-green hover:bg-upwork-light-green text-white font-semibold py-3 px-6 rounded-full inline-block transition duration-300">Return
            to Homepage</a>
    </div>
</body>

</html>
