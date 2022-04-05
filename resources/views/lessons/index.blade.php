@extends('layouts.base')

@section('content')
<h1 class="text-3xl mb-8">My Classes</h1>

<div class="overflow-x-auto">
    <table class="table-fixed min-w-full text-sm divide-y-2 divide-gray-200">
        <thead>
        <tr>
            <th class="pr-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Class Name</th>
            <th class="pr-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Lesson Start</th>
            <th class="pr-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Lesson End</th>
            <th class="w-48 pr-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap text-right">Action</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        @foreach($lessons as $lesson)
            <tr>
                <td class="pr-4 py-4 text-gray-700 whitespace-nowrap">{{ $lesson->class_name }}</td>
                <td class="pr-4 py-4 text-gray-700 whitespace-nowrap">{{ date('H:i - jS F Y', strtotime($lesson->start_at->date)) }}</td>
                <td class="pr-4 py-4 text-gray-700 whitespace-nowrap">{{ date('H:i - jS F Y', strtotime($lesson->end_at->date)) }}</td>
                <td class="w-48 py-4 text-right"><a href="{{ route('lessons.show', $lesson->class_id) }}" class="inline-block px-4 py-3 text-sm font-medium text-white bg-blue-500 rounded">View Students</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
