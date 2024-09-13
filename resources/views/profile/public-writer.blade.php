<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-4">{{ $writer->name }}</h1>
        <img src="{{ $writer->profile_image ? asset('storage/' . $writer->profile_image) : 'default-avatar.png' }}"
            alt="Profile Image" class="w-24 h-24 rounded-full mb-4">
        <p><strong>Bio:</strong> {{ $writer->bio }}</p>
        <p><strong>Skills:</strong> {{ $writer->skills }}</p>
    </div>
</body>

</html>
