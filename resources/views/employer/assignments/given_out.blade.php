@extends('layouts.employer')

@section('content')
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 15px;
        }

        .section-title {
            color: #14a800;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card {
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            margin-bottom: 15px;
            padding: 12px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #14a800;
        }

        .card-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-info {
            flex: 1;
        }

        .card-actions {
            display: flex;
            align-items: center;
        }

        .status-badge {
            background: #e0f7e0;
            color: #14a800;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 5px;
        }

        .btn-primary {
            background-color: #14a800;
            color: #fff;
        }

        .btn-secondary {
            background-color: #0077b5;
            color: #fff;
        }

        .empty-state {
            text-align: center;
            color: #666;
            padding: 20px 0;
        }

        .assignment-title {
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 5px;
        }

        .assignment-details {
            font-size: 12px;
            color: #666;
        }

        .writer-info {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .writer-image {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 5px;
        }

        .action-menu {
            position: absolute;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            padding: 5px 0;
            z-index: 10;
            display: none;
        }

        .action-menu a,
        .action-menu button {
            display: block;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 12px;
            cursor: pointer;
        }

        .action-menu a:hover,
        .action-menu button:hover {
            background-color: #f2f2f2;
        }
    </style>

    <div class="dashboard-container">
        <h1 class="section-title">Ongoing Assignments</h1>

        @forelse ($assignments as $assignment)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Order #{{ $assignment->id }}</span>
                    <span class="status-badge">Ongoing</span>
                </div>
                <div class="card-content">
                    <div class="card-info">
                        <h2 class="assignment-title">{{ $assignment->title }}</h2>
                        <p class="assignment-details">
                            Deadline: {{ $assignment->deadline->format('Y-m-d') }} |
                            Budget: KES {{ number_format($assignment->budget, 2) }} |
                            Word Count: {{ $assignment->word_count }}
                        </p>
                        <div class="writer-info">
                            @if ($assignment->acceptedBid && $assignment->acceptedBid->writer)
                                <img src="{{ asset('storage/' . $assignment->acceptedBid->writer->profile_image) }}"
                                    alt="Writer Image" class="writer-image">
                                <span
                                    style="color: #14a800; font-weight: 600;">{{ $assignment->acceptedBid->writer->name }}</span>
                            @else
                                <span style="color: #808080; font-style: italic;">Checking...</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <div style="position: relative;">
                            <button onclick="toggleMenu(event)" class="btn btn-secondary">Actions</button>
                            <div class="action-menu">
                                <a href="{{ route('employer.assignments.show', $assignment->id) }}">View Details</a>
                                <form action="{{ route('employer.assignments.markAsCompleted', $assignment->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">Mark as Completed</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card empty-state">
                <p>No ongoing assignments found.</p>
            </div>
        @endforelse

        <h1 class="section-title">Completed Assignments</h1>

        @forelse ($completedAssignments as $assignment)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Order #{{ $assignment->id }}</span>
                    <span class="status-badge">Completed</span>
                </div>
                <div class="card-content">
                    <div class="card-info">
                        <h2 class="assignment-title">{{ $assignment->title }}</h2>
                        <p class="assignment-details">
                            Deadline: {{ $assignment->deadline->format('Y-m-d') }} |
                            Budget: KES {{ number_format($assignment->budget, 2) }} |
                            Word Count: {{ $assignment->word_count }}
                        </p>
                        <div class="writer-info">
                            @if ($assignment->acceptedBid && $assignment->acceptedBid->writer)
                                <img src="{{ asset('storage/' . $assignment->acceptedBid->writer->profile_image) }}"
                                    alt="Writer Image" class="writer-image">
                                <span
                                    style="color: #14a800; font-weight: 600;">{{ $assignment->acceptedBid->writer->name }}</span>
                            @else
                                <span style="color: #808080; font-style: italic;">N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('ratings.create', $assignment->acceptedBid->writer->id) }}"
                            class="btn btn-primary">Rate Writer</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card empty-state">
                <p>No completed assignments found.</p>
            </div>
        @endforelse
    </div>

    <script>
        function toggleMenu(event) {
            const menu = event.currentTarget.nextElementSibling;
            const isVisible = menu.style.display === 'block';
            menu.style.display = isVisible ? 'none' : 'block';

            document.addEventListener('click', function outsideClick(event) {
                if (!event.target.closest('.btn-secondary') && !event.target.closest('.action-menu')) {
                    menu.style.display = 'none';
                    document.removeEventListener('click', outsideClick);
                }
            });
        }
    </script>
@endsection
