@extends('layouts.employer')

@section('content')
    <div style="max-width: 1000px; margin: 0 auto; padding: 30px 15px; font-family: 'Poppins', sans-serif;">
        <h1 style="color: #14a800; font-size: 22px; margin-bottom: 25px; text-align: center; font-weight: 600;">Available
            Writers</h1>

        <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            @foreach ($writers as $writer)
                <a href="{{ route('writer.profile.public', $writer->id) }}"
                    style="text-decoration: none; color: inherit; width: 100%; max-width: 700px;">
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
                                {{ $writer->name }}</h2>
                            <p style="color: #14a800; font-size: 14px; margin: 0 0 5px;">Online</p>
                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                @foreach (array_slice(explode(',', $writer->skills), 0, 4) as $skill)
                                    <span
                                        style="background-color: #e4f7e4; color: #14a800; padding: 3px 8px; border-radius: 3px; font-size: 11px;">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
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

        a[style*="max-width: 700px"]:hover div {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            a[style*="max-width: 700px"] div {
                flex-direction: column;
                align-items: start;
            }

            a[style*="max-width: 700px"] div>div:last-child {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            a[style*="max-width: 700px"] {
                width: 100%;
            }
        }
    </style>
@endsection
