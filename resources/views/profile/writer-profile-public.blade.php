<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Profile - {{ $writer->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            color: #001e00;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 0;
        }

        .logo {
            max-width: 100px;
            height: auto;
        }

        .profile-header {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 40px;
            display: flex;
            align-items: flex-start;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 40px;
        }

        .profile-info h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .profile-info p {
            font-size: 16px;
            color: #5e6d55;
            margin: 0 0 20px 0;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .skill {
            background-color: #e4ebe4;
            color: #001e00;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
        }

        .ratings {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 40px;
        }

        .ratings h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 20px 0;
        }

        .rating-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 0;
        }

        .rating-item:last-child {
            border-bottom: none;
        }

        .rating-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .rating-stars {
            color: #14a800;
            font-weight: 700;
        }

        .back-link {
            display: inline-block;
            background-color: #14a800;
            color: #ffffff;
            text-decoration: none;
            border-radius: 24px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            margin-top: 40px;
            transition: background-color 0.2s;
        }

        .back-link:hover {
            background-color: #3c8224;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <img src="/images/logo.png" alt="Logo" class="logo">
        </div>
    </header>
    <div class="container">
        <div class="profile-header">
            <!-- Display the writer's profile image or fallback to a default image -->
            <img src="{{ $writer->profile_image ? asset('storage/' . $writer->profile_image) : asset('images/default-profile.jpg') }}"
                alt="{{ $writer->name }}" class="profile-image">


            <div class="profile-info">
                <h1>{{ $writer->name }}</h1>
                <p>{{ $writer->bio }}</p>
                <div class="skills">
                    @foreach (explode(',', $writer->skills) as $skill)
                        <span class="skill">{{ trim($skill) }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="ratings">
            <h2>Client Reviews</h2>
            <p>Average Rating: <span class="rating-stars">{{ number_format($averageRating, 1) }}</span> / 5</p>
            @foreach ($writer->ratings as $rating)
                <div class="rating-item">
                    <div class="rating-header">
                        <strong>{{ $rating->employer->name }}</strong>
                        <span class="rating-stars">{{ $rating->rating }} / 5</span>
                    </div>
                    <p>{{ $rating->remarks }}</p>
                </div>
            @endforeach
        </div>
        <a href="/" class="back-link">Back to Home</a>
    </div>
</body>


</html>
