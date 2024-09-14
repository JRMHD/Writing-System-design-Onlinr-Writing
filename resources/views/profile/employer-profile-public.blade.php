<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employer->name }}'s Public Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #14171a;
            background-color: #f2f7f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 2rem;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-right: 1rem;
        }

        h1 {
            color: #37a000;
            margin: 0;
        }

        .profile-section {
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .profile-section h2 {
            color: #14171a;
            margin-top: 0;
        }

        .bio {
            font-size: 1rem;
            color: #5e6d55;
        }

        .dashboard-link {
            display: inline-block;
            background-color: #37a000;
            color: white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .dashboard-link:hover {
            background-color: #2c8000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="/images/logo.png" alt="Company Logo" class="logo">
            <h1>{{ $employer->name }}'s Profile</h1>
        </div>

        <div class="profile-section">
            <h2>About</h2>
            <p class="bio">{{ $employer->bio }}</p>
        </div>

        <a href="/employer/profile" class="dashboard-link">Back to Edit</a>
    </div>
</body>

</html>
