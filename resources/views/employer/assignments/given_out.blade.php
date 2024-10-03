@extends('layouts.employer')

@section('content')
    <div style="font-family: 'Poppins', sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #14a800; font-size: 24px; font-weight: 600; margin-bottom: 20px;">Ongoing Assignments</h1>
        <div style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Title</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Word Count</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Deadline</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Budget</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Assigned Writer</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->title }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->word_count }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                {{ $assignment->deadline->format('Y-m-d') }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">KES
                                {{ number_format($assignment->budget, 2) }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                @if ($assignment->acceptedBid && $assignment->acceptedBid->writer)
                                    <img src="{{ asset('storage/' . $assignment->acceptedBid->writer->profile_image) }}"
                                        alt="Writer Image"
                                        style="width: 25px; height: 25px; border-radius: 50%; object-fit: cover; margin-right: 5px;">
                                    <span
                                        style="color: #14a800; font-weight: 600;">{{ $assignment->acceptedBid->writer->name }}</span>
                                @else
                                    <span style="color: #808080; font-style: italic;">Checking...</span>
                                @endif
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                <a href="{{ route('employer.assignments.show', $assignment->id) }}"
                                    style="display: inline-block; padding: 8px 16px; background-color: #14a800; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background-color 0.3s;">View
                                    Details</a>
                                <form action="{{ route('employer.assignments.markAsCompleted', $assignment->id) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        style="padding: 8px 16px; background-color: #14a800; color: #ffffff; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;">Mark
                                        as Completed</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 style="color: #14a800; font-size: 20px; font-weight: 600; margin-top: 40px;">Completed Assignments</h2>
        <div
            style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden; margin-top: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Title</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Word Count</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Deadline</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Budget</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Assigned Writer</th>
                        <th
                            style="padding: 15px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #656565; font-weight: 600;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($completedAssignments as $assignment)
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->title }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">{{ $assignment->word_count }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                {{ $assignment->deadline->format('Y-m-d') }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">KES
                                {{ number_format($assignment->budget, 2) }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                @if ($assignment->acceptedBid && $assignment->acceptedBid->writer)
                                    <img src="{{ asset('storage/' . $assignment->acceptedBid->writer->profile_image) }}"
                                        alt="Writer Image"
                                        style="width: 25px; height: 25px; border-radius: 50%; object-fit: cover; margin-right: 5px;">
                                    <span
                                        style="color: #14a800; font-weight: 600;">{{ $assignment->acceptedBid->writer->name }}</span>
                                @else
                                    <span style="color: #808080; font-style: italic;">N/A</span>
                                @endif
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #e0e0e0;">
                                <a href="{{ route('ratings.create', $assignment->acceptedBid->writer->id) }}"
                                    style="display: inline-block; padding: 8px 16px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background-color 0.3s;">Rate
                                    Writer</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
