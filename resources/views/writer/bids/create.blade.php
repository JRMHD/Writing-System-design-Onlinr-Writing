 @extends('layouts.writer')

 @section('title', 'Place a Bid')

 @section('content')
     <div class="container" style="padding: 2rem; max-width: 800px; margin: auto;">
         <h1 style="color: var(--deep-orange); margin-bottom: 1rem; font-size: 2rem;">Place a Bid</h1>

         <form action="{{ route('writer.bids.store') }}" method="POST"
             style="background-color: var(--white); padding: 2rem; border-radius: 0.5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
             @csrf

             <!-- Assignment Selection -->
             <div class="form-group mb-4">
                 <label for="assignment_id"
                     style="font-weight: 600; color: var(--dark-gray); font-size: 1rem;">Assignment</label>
                 <select name="assignment_id" id="assignment_id" class="form-control" required
                     style="padding: 0.75rem; border: 1px solid var(--light-gray); border-radius: 0.25rem; width: 100%; font-size: 1rem;">
                     <option value="" disabled selected>Select an assignment</option>
                     @foreach ($assignments as $assignment)
                         <option value="{{ $assignment->id }}">{{ $assignment->title }}</option>
                     @endforeach
                 </select>
             </div>

             <!-- Bid Amount -->
             <div class="form-group mb-4">
                 <label for="amount" style="font-weight: 600; color: var(--dark-gray); font-size: 1rem;">Bid
                     Amount</label>
                 <input type="number" name="amount" id="amount" class="form-control" step="0.01" required
                     style="padding: 0.75rem; border: 1px solid var(--light-gray); border-radius: 0.25rem; width: 100%; font-size: 1rem;">
             </div>

             <!-- Message -->
             <div class="form-group mb-4">
                 <label for="message" style="font-weight: 600; color: var(--dark-gray); font-size: 1rem;">Message</label>
                 <textarea name="message" id="message" class="form-control" rows="4" placeholder="Add a message (optional)"
                     style="padding: 0.75rem; border: 1px solid var(--light-gray); border-radius: 0.25rem; width: 100%; font-size: 1rem;"></textarea>
             </div>

             <!-- Submit Button -->
             <button type="submit" class="btn btn-primary"
                 style="background-color: var(--deep-orange); border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; color: var(--white); font-size: 1rem; font-weight: 600; text-transform: uppercase; transition: background-color 0.3s ease; cursor: pointer;">
                 Submit Bid
             </button>
         </form>
     </div>
 @endsection
