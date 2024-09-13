<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Writer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 32px;
            width: 100%;
            max-width: 480px;
        }

        h1 {
            color: #001e00;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        label {
            display: block;
            color: #5e6d55;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        input[type="file"] {
            padding: 8px 0;
        }

        button {
            background-color: #14a800;
            color: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #3c8224;
        }

        .status {
            color: #14a800;
            margin-bottom: 16px;
        }

        .error {
            color: #d14836;
            margin-bottom: 16px;
        }

        .dashboard-link {
            display: inline-block;
            background-color: #001e00;
            color: #ffffff;
            text-decoration: none;
            border-radius: 24px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            margin-top: 16px;
            transition: background-color 0.2s;
        }

        .dashboard-link:hover {
            background-color: #052e05;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Your Profile</h1>

        @if (session('status'))
            <p class="status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <ul class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('writer.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="profile_image">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image">
            </div>
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', auth()->guard('writer')->user()->name) }}">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', auth()->guard('writer')->user()->email) }}" readonly>
            </div>
            <div>
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4">{{ old('bio', auth()->guard('writer')->user()->bio) }}</textarea>
            </div>
            <div>
                <label for="skills">Skills</label>
                <input type="text" id="skills" name="skills"
                    value="{{ old('skills', auth()->guard('writer')->user()->skills) }}">
            </div>

            <button type="submit">Save Changes</button>
        </form>

        <a href="/writer/dashboard" class="dashboard-link">Go to Dashboard</a>
    </div>
</body>

</html>
