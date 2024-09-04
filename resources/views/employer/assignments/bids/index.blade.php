<!DOCTYPE html>
<html>

<head>
    <title>Bids for Assignment</title>
</head>

<body>
    <h1>Bids for Assignment: {{ $assignment->title }}</h1>
    <table>
        <thead>
            <tr>
                <th>Writer</th>
                <th>Bid Amount</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignment->bids as $bid)
                <tr>
                    <td>{{ $bid->writer->name }}</td>
                    <td>${{ $bid->bid_amount }}</td>
                    <td>{{ $bid->message }}</td>
                    <td>
                        <form action="{{ route('employer.assignments.selectWriter', $assignment->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                            <button type="submit">Select</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
