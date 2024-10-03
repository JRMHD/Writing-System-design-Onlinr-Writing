<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Writer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            padding: 16px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logout-form {
            display: flex;
            justify-content: flex-end;
        }

        .logout-button {
            background-color: #d14836;
            color: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .logout-button:hover {
            background-color: #c53727;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            padding: 32px 16px;
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

        .dashboard-link,
        .public-link {
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

        .dashboard-link:hover,
        .public-link:hover {
            background-color: #052e05;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .progress {
            width: 0;
            height: 20px;
            background-color: #14a800;
            border-radius: 10px;
            transition: width 0.5s ease-in-out;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <form method="POST" action="{{ route('writer.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </header>
        <main class="content">
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

                <div class="progress-bar">
                    <div class="progress" style="width: {{ $writer->profile_completion }}%;"></div>
                </div>
                <p>Profile Completion: {{ $writer->profile_completion }}%</p>

                <form method="POST" action="{{ route('writer.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <!-- Display profile image or a default image if not available -->
                        <img src="{{ $writer->profile_image ? asset('storage/' . $writer->profile_image) : asset('images/default-profile.jpg') }}"
                            alt="Profile Image" class="profile-image">

                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image">
                    </div>
                    <!-- Cropping area and buttons -->
                    <div id="cropper-container" style="display: none; margin-top: 20px;">
                        <img id="cropper-image" style="max-width: 100%;">
                    </div>

                    <!-- Buttons for cropping and resetting -->
                    <button type="button" id="crop-button" style="display: none;">Crop Image</button>
                    <button type="button" id="reset-button" style="display: none;">Reset Image</button>

                    <!-- Hidden input to store the cropped image data -->
                    <input type="hidden" id="cropped_image_data" name="cropped_image_data">

                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $writer->name) }}">
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $writer->email) }}"
                            readonly>
                    </div>
                    <div>
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio" rows="4">{{ old('bio', $writer->bio) }}</textarea>
                    </div>
                    <div>
                        <label for="skills">Skills</label>
                        <input type="text" id="skills" name="skills"
                            value="{{ old('skills', $writer->skills) }}">
                    </div>

                    <button type="submit">Save Changes</button>
                </form>

                <a href="{{ route('writer.dashboard') }}" class="dashboard-link">Go to Dashboard</a>
                <a href="{{ route('writer.profile.public', $writer->id) }}" class="public-link">View as Public</a>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const profileImageInput = document.getElementById('profile_image');
                const cropperContainer = document.getElementById('cropper-container');
                const cropperImage = document.getElementById('cropper-image');
                const cropButton = document.getElementById('crop-button');
                const resetButton = document.getElementById('reset-button');
                const croppedImageDataInput = document.getElementById('cropped_image_data');
                let cropper;

                // When user selects a file
                profileImageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            cropperImage.src = e.target.result;
                            cropperContainer.style.display = 'block';
                            cropButton.style.display = 'inline-block';
                            resetButton.style.display = 'inline-block';

                            // Initialize Cropper.js
                            if (cropper) {
                                cropper.destroy(); // Destroy old cropper instance
                            }
                            cropper = new Cropper(cropperImage, {
                                aspectRatio: 1, // 1:1 ratio for a square profile image
                                viewMode: 1, // Restricts the crop box to the image bounds
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Crop the image and store the result in hidden input
                cropButton.addEventListener('click', function() {
                    if (cropper) {
                        const croppedCanvas = cropper.getCroppedCanvas({
                            width: 150, // Desired width for the final image
                            height: 150 // Desired height
                        });
                        croppedCanvas.toBlob(function(blob) {
                            const reader = new FileReader();
                            reader.onloadend = function() {
                                croppedImageDataInput.value = reader.result; // Base64 image data
                                document.getElementById('profileImagePreview').src = reader
                                .result; // Update preview
                            };
                            reader.readAsDataURL(blob);
                        });
                        cropperContainer.style.display = 'none';
                        cropButton.style.display = 'none';
                        resetButton.style.display = 'none';
                    }
                });

                // Reset the cropper and image preview
                resetButton.addEventListener('click', function() {
                    cropper.destroy();
                    cropperContainer.style.display = 'none';
                    cropButton.style.display = 'none';
                    resetButton.style.display = 'none';
                    document.getElementById('profileImagePreview').src =
                        '{{ $writer->profile_image ? asset('storage/' . $writer->profile_image) : asset('images/default-profile.jpg') }}';
                    profileImageInput.value = ''; // Reset the input
                    croppedImageDataInput.value = ''; // Clear cropped image data
                });
            });
        </script>

    </div>
</body>

</html>
