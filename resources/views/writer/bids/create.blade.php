@extends('layouts.writer')

@section('title', 'Place a Bid')

@section('content')
    <div style="font-family: 'Poppins', Arial, sans-serif; background-color: #f2f2f2; padding: 40px;">
        <div style="max-width: 900px; margin: 0 auto;">
            <!-- Header -->
            <div
                style="background-color: #ffffff; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.12);">
                <h1 style="color: #14a800; font-size: 28px; font-family: 'Poppins SemiBold'; margin: 0 0 15px 0;">
                    Place a Bid for "{{ $assignment->title }}"
                </h1>
                <p style="color: #5e6d55; font-size: 16px; font-family: 'Poppins Medium';">Submit your proposal</p>
            </div>

            <!-- Bid Form -->
            <div
                style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.12); padding: 30px;">
                <form action="{{ route('writer.bids.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                    <!-- Bid Amount Input -->
                    <div style="margin-bottom: 30px;">
                        <label for="amount"
                            style="display: block; color: #5e6d55; font-size: 16px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            Bid Amount
                        </label>
                        <input type="number" name="amount" id="amount" required step="0.01"
                            style="width: 100%; padding: 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 16px; font-family: 'Poppins Regular';">
                    </div>

                    <!-- Message Textarea -->
                    <div style="margin-bottom: 30px;">
                        <label for="message"
                            style="display: block; color: #5e6d55; font-size: 16px; font-family: 'Poppins Medium'; margin-bottom: 10px;">
                            Message
                        </label>
                        <textarea name="message" id="message" rows="6" placeholder="Add a message (optional)"
                            style="width: 100%; padding: 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 16px; font-family: 'Poppins Regular'; resize: vertical;"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        style="background-color: #14a800; color: white; border: none; padding: 14px 28px; border-radius: 24px; font-size: 16px; font-family: 'Poppins SemiBold'; text-transform: uppercase; cursor: pointer; transition: background-color 0.3s ease;">
                        Submit Bid
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
