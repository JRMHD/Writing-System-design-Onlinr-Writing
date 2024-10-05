@extends('layouts.employer')

@section('title', 'Rate ' . $writer->name)

@section('content')
    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <div
            style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); padding: 40px; margin-top: 40px;">
            <h1
                style="font-size: 24px; font-weight: 600; margin: 0 0 20px 0; color: #001e00; font-family: 'Poppins', sans-serif;">
                Rate {{ $writer->name }}</h1>

            <div
                style="margin-bottom: 30px; color: #5e6d55; font-size: 15px; line-height: 1.5; font-family: 'Poppins', sans-serif; font-weight: 400;">
                <p style="margin-bottom: 15px;">Your feedback is invaluable! By rating {{ $writer->name }}, you're:</p>
                <ul style="padding-left: 20px; margin-bottom: 15px;">
                    <li>Helping other employers make informed decisions</li>
                    <li>Encouraging high-quality work from writers</li>
                    <li>Contributing to a more efficient and reliable platform</li>
                </ul>
                <p style="margin-bottom: 15px;">Your honest rating and comments will help {{ $writer->name }} improve their
                    services and assist other employers in finding the right talent for their projects.</p>
                <p style="font-weight: 500; color: #14a800;">It only takes a minute, but its impact lasts much longer!</p>
            </div>

            <form action="{{ route('ratings.store', $writer->id) }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label for="rating"
                        style="display: block; font-size: 20px; font-weight: 600; margin-bottom: 8px; color: #001e00; font-family: 'Poppins', sans-serif;">Rating
                        (1-5)</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required
                        style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 15px; color: #001e00; font-family: 'Poppins', sans-serif; font-weight: 400;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="remarks"
                        style="display: block; font-size: 20px; font-weight: 600; margin-bottom: 8px; color: #001e00; font-family: 'Poppins', sans-serif;">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="4"
                        style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 15px; color: #001e00; resize: vertical; min-height: 100px; font-family: 'Poppins', sans-serif; font-weight: 400;"
                        placeholder="Share your experience working with {{ $writer->name }}. What went well? Any areas for improvement?"></textarea>
                </div>
                <button type="submit"
                    style="background-color: #14a800; color: #ffffff; border: none; border-radius: 24px; padding: 12px 24px; font-size: 15px; font-weight: 500; cursor: pointer; transition: background-color 0.2s; font-family: 'Poppins', sans-serif;">Submit
                    Rating</button>
            </form>
        </div>
        <a href="{{ route('writer.profile.public', $writer->id) }}"
            style="display: inline-block; margin-top: 20px; color: #14a800; text-decoration: none; font-weight: 500; font-size: 15px; font-family: 'Poppins', sans-serif;">Back
            to Profile</a>
    </div>
@endsection

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            color: #001e00;
        }
    </style>
@endpush
