@extends('layouts.employer')

@section('content')
    <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F7F9FA; padding: 2rem;">
        <div style="max-width: 900px; margin: 0 auto;">
            <!-- Title -->
            <h1 style="font-size: 2.5rem; font-weight: 600; color: #00A86B; text-align: center; margin-bottom: 2rem;">
                Edit Assignment
            </h1>

            <!-- Error Handling -->
            @if ($errors->any())
                <div
                    style="background-color: #F8D7DA; color: #721C24; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 0.5rem;">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form to Edit Assignment -->
            <form action="{{ route('employer.assignments.update', $assignment->id) }}" method="POST"
                style="background-color: #ffffff; padding: 2.5rem; border-radius: 1rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                @csrf
                @method('PUT')

                <!-- Form Fields Grouped in Two Columns -->
                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 2rem;">
                    <!-- Left Column -->
                    <div style="flex: 1;">
                        <div style="margin-bottom: 1.5rem;">
                            <label for="title"
                                style="font-weight: 600; margin-bottom: 0.5rem; display: block; color: #333;">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $assignment->title }}" required
                                style="width: 100%; padding: 1rem; border: 1px solid #D1D5DB; border-radius: 0.75rem; font-size: 1rem; transition: border-color 0.3s ease;">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="word_count"
                                style="font-weight: 600; margin-bottom: 0.5rem; display: block; color: #333;">Word
                                Count</label>
                            <input type="number" class="form-control" id="word_count" name="word_count"
                                value="{{ $assignment->word_count }}" required
                                style="width: 100%; padding: 1rem; border: 1px solid #D1D5DB; border-radius: 0.75rem; font-size: 1rem; transition: border-color 0.3s ease;">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div style="flex: 1;">
                        <div style="margin-bottom: 1.5rem;">
                            <label for="deadline"
                                style="font-weight: 600; margin-bottom: 0.5rem; display: block; color: #333;">Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline"
                                value="{{ $assignment->deadline }}" required
                                style="width: 100%; padding: 1rem; border: 1px solid #D1D5DB; border-radius: 0.75rem; font-size: 1rem; transition: border-color 0.3s ease;">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="budget"
                                style="font-weight: 600; margin-bottom: 0.5rem; display: block; color: #333;">Budget</label>
                            <input type="number" class="form-control" id="budget" name="budget"
                                value="{{ $assignment->budget }}" step="0.01" required
                                style="width: 100%; padding: 1rem; border: 1px solid #D1D5DB; border-radius: 0.75rem; font-size: 1rem; transition: border-color 0.3s ease;">
                        </div>
                    </div>
                </div>

                <!-- Full-width Textarea for Description -->
                <div style="margin-bottom: 2rem;">
                    <label for="description"
                        style="font-weight: 600; margin-bottom: 0.5rem; display: block; color: #333;">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="6" required
                        style="width: 100%; padding: 1rem; border: 1px solid #D1D5DB; border-radius: 0.75rem; font-size: 1rem; transition: border-color 0.3s ease;">{{ $assignment->description }}</textarea>
                </div>

                <!-- Submit Button -->
                <div style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #00A86B; border: none; color: #fff; padding: 0.75rem 2rem; border-radius: 0.75rem; font-size: 1.2rem; cursor: pointer; transition: background-color 0.3s ease;">
                        Update Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Hover Effects */
        .form-control:hover {
            border-color: #00A86B;
        }

        .form-control:focus {
            outline: none;
            border-color: #00A86B;
            box-shadow: 0 0 5px rgba(0, 168, 107, 0.5);
        }

        button:hover {
            background-color: #00795d;
        }
    </style>
@endsection
