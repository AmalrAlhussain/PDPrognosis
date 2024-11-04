@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>please review data before confirm uploaded </h2>
        <p>
            <strong>File Type:</strong> {{ $data['file_type'] }} /
        <strong>Patient ID:</strong> {{ $data['patient_id'] }}</p>

     <div class="table-responsive">
         <table class="table table-bordered">
             <thead>
             <tr>
                 @foreach($previewData[0] as $header)
                     <th>{{ $header }}</th>
                 @endforeach
             </tr>
             </thead>
             <tbody>
             @foreach($previewData as $index => $row)
                 @if($index > 0) <!-- Skip the header row -->
                 <tr>
                     @foreach($row as $cell)
                         <td>{{ $cell }}</td>
                     @endforeach
                 </tr>
                 @endif
             @endforeach
             </tbody>
         </table>
     </div>

        <!-- Confirm button -->
        <form action="{{ route('admin.visit.confirm_upload') }}" method="POST">
            @csrf
            <input type="hidden" name="previewData" value="{{ json_encode($previewData) }}">
            <input type="hidden" name="file_type" value="{{ $data['file_type'] }}">
            <button type="submit" class="btn btn-success">Confirm Upload</button>
        </form>
    </div>
@endsection
