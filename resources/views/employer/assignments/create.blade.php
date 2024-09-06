@extends('layouts.employer')

@section('content')
    <div
        style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 2rem; max-width: 1200px; margin: 0 auto;">

        <!-- Title -->
        <h1 style="color: #28a745; font-size: 2.5rem; margin-bottom: 2rem; text-align: center;">Create New Assignment</h1>

        <!-- Error Handling -->
        @if ($errors->any())
            <div
                style="background-color: #f8d7da; color: #721c24; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <ul style="list-style: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom: 0.5rem;">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to Create Assignment -->
        <form action="{{ route('employer.assignments.store') }}" method="POST"
            style="background-color: #ffffff; padding: 2.5rem; border-radius: 12px; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);">
            @csrf

            <!-- Form Fields Grouped in Two Columns -->
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Left Column -->
                <div style="flex: 1; min-width: 300px;">
                    <div style="margin-bottom: 1.5rem;">
                        <label for="title" style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required
                            style="width: 100%; padding: 1rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="word_count" style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Word
                            Count</label>
                        <input type="number" class="form-control" id="word_count" name="word_count" required
                            style="width: 100%; padding: 1rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;">
                    </div>
                </div>

                <!-- Right Column -->
                <div style="flex: 1; min-width: 300px;">
                    <div style="margin-bottom: 1.5rem;">
                        <label for="deadline"
                            style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" required
                            style="width: 100%; padding: 1rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="budget"
                            style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget" step="0.01" required
                            style="width: 100%; padding: 1rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;">
                    </div>
                </div>
            </div>

            <!-- Full-width Textarea for Description -->
            <div style="margin-bottom: 2rem;">
                <label for="description"
                    style="font-weight: 600; margin-bottom: 0.5rem; display: block;">Description</label>
                <textarea class="form-control" id="description" name="description" rows="6" required
                    style="width: 100%; padding: 1rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"></textarea>
            </div>

            <!-- Submit Button -->
            <div style="text-align: center; margin-top: 2rem;">
                <button type="submit"
                    style="background-color: #28a745; border: none; color: #fff; padding: 0.75rem 2.5rem; border-radius: 8px; font-size: 1.2rem; cursor: pointer; transition: background-color 0.3s ease;">
                    Create Assignment
                </button>
            </div>
        </form>
    </div>

    <style>
        /* Hover Effects */
        .form-control:hover {
            border-color: #28a745;
        }

        .form-control:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        button:hover {
            background-color: #218838;
        }
    </style>
@endsection
