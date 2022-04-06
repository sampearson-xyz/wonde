@extends('layouts.base')

@section('content')
    <h1 class="text-3xl mb-8">{{ $lesson->class_name }}</h1>

    <div class="overflow-x-auto">
        <table class="table-fixed min-w-full text-sm divide-y-2 divide-gray-200">
            <thead>
            <tr>
                <th class="pr-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Student Name</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @foreach($lesson->students as $student)
                <tr>
                    <td class="pr-4 py-4 text-gray-700 whitespace-nowrap">{{ $student->forename }} {{ $student->surname }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
