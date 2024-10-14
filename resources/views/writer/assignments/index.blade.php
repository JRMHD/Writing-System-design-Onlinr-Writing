@extends('layouts.writer')
@section('title', 'Available Assignments')

@section('content')
    <div
        style="font-family: 'Poppins', sans-serif; background-color: #f2f7f2; margin: 0; padding: 40px 20px; color: #001e00; min-height: 100vh;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <!-- Header -->
            <div
                style="background-color: #ffffff; padding: 30px; border-radius: 16px; margin-bottom: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <h1 style="color: #14a800; font-size: 32px; font-weight: 700; margin: 0; letter-spacing: -0.5px;">Available
                    Jobs</h1>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
                @foreach ($assignments as $assignment)
                    <div
                        style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 30px; transition: all 0.3s ease; position: relative; overflow: hidden;">
                        <h2
                            style="color: #001e00; font-size: 22px; font-weight: 600; margin-bottom: 20px; line-height: 1.3;">
                            {{ $assignment->title }}
                        </h2>
                        <p
                            style="color: #5e6d55; font-size: 16px; margin: 0 0 12px; font-weight: 400; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                style="width: 18px; height: 18px; margin-right: 8px;">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                            <strong>Word Count:</strong> {{ $assignment->word_count }}
                        </p>
                        <p
                            style="color: #5e6d55; font-size: 16px; margin: 0 0 12px; font-weight: 400; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                style="width: 18px; height: 18px; margin-right: 8px;">
                                <path
                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                            </svg>
                            <strong>Deadline:</strong> {{ $assignment->deadline->format('M d, Y') }}
                        </p>
                        <p
                            style="color: #5e6d55; font-size: 16px; margin: 0 0 25px; font-weight: 400; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                style="width: 18px; height: 18px; margin-right: 8px;">
                                <path
                                    d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                            </svg>
                            <strong>Budget:</strong> <span style="color: #14a800; font-weight: 600;">KES
                                {{ number_format($assignment->budget, 2) }}</span>
                        </p>
                        <a href="{{ route('writer.assignments.show', $assignment->id) }}"
                            style="background-color: #14a800; color: white; text-decoration: none; padding: 12px 24px; border-radius: 30px; font-size: 16px; font-weight: 600; display: inline-block; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(20, 168, 0, 0.2);">
                            View Details
                        </a>
                        <div
                            style="position: absolute; top: 0; right: 0; width: 0; height: 0; border-style: solid; border-width: 0 50px 50px 0; border-color: transparent #14a800 transparent transparent; opacity: 0.1;">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
