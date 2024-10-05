@extends('layouts.employer')
@section('content')
    <div style="max-width: 1000px; margin: 0 auto; padding: 30px 15px; font-family: 'Poppins', sans-serif;">
        <h1 style="color: #14a800; font-size: 22px; margin-bottom: 25px; text-align: center; font-weight: 600;">Available
            Writers</h1>

        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            @foreach ($writers as $writer)
                <div style="width: 100%; max-width: 700px;">
                    <div
                        style="border: 1px solid #e4e4e4; border-radius: 10px; background-color: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 15px; display: flex; align-items: center; gap: 15px; transition: box-shadow 0.3s ease, transform 0.3s ease;">
                        <div style="position: relative; width: 50px; height: 50px; flex-shrink: 0;">
                            <img src="{{ $writer->profile_image ? asset('storage/' . $writer->profile_image) : asset('images/default-profile.jpg') }}"
                                alt="{{ $writer->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            <span
                                style="position: absolute; bottom: 0; right: 0; width: 10px; height: 10px; background-color: #14a800; border-radius: 50%; box-shadow: 0 0 0 2px #fff, 0 0 0 4px #14a800, 0 0 5px 4px rgba(20, 168, 0, 0.5); animation: glow 1.5s infinite alternate;"></span>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h2
                                style="color: #001e00; font-size: 18px; font-weight: 600; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $writer->name }}
                            </h2>
                            <p style="color: #14a800; font-size: 14px; margin: 0 0 5px;">
                                <i class="fas fa-circle" style="font-size: 10px; margin-right: 5px;"></i>Online
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                @foreach (array_slice(explode(',', $writer->skills), 0, 4) as $skill)
                                    <span
                                        style="background-color: #e4f7e4; color: #14a800; padding: 3px 8px; border-radius: 3px; font-size: 11px;">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown" style="position: relative;">
                            <button onclick="toggleDropdown(this)" class="dropbtn"
                                style="background-color: #14a800; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div id="myDropdown" class="dropdown-content"
                                style="display: none; position: absolute; right: 0; background-color: #f1f1f1; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px;">
                                <a href="{{ route('writer.profile.public', $writer->id) }}"
                                    style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
                                    <i class="fas fa-user" style="margin-right: 10px;"></i>View Profile
                                </a>
                                <a href="#"
                                    style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
                                    <i class="fas fa-envelope" style="margin-right: 10px;"></i>Send Message
                                </a>
                                <a href="#"
                                    style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
                                    <i class="fas fa-briefcase" style="margin-right: 10px;"></i>Invite to Job
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        @keyframes glow {
            0% {
                box-shadow: 0 0 0 2px #fff, 0 0 0 4px #14a800, 0 0 5px 4px rgba(20, 168, 0, 0.5);
            }

            100% {
                box-shadow: 0 0 0 2px #fff, 0 0 0 4px #14a800, 0 0 8px 6px rgba(20, 168, 0, 0.8);
            }
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        @media (max-width: 768px) {
            div[style*="max-width: 700px"]>div {
                flex-direction: column;
                align-items: start;
            }

            div[style*="max-width: 700px"]>div>div:last-child {
                width: 100%;
            }

            .dropdown {
                align-self: flex-end;
                margin-top: 10px;
            }
        }

        @media (max-width: 480px) {
            div[style*="max-width: 700px"] {
                width: 100%;
            }
        }
    </style>

    <script>
        function toggleDropdown(button) {
            var dropdownContent = button.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
