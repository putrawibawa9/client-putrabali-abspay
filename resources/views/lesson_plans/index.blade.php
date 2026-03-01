@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        Lesson Plan History
    </h1>

    @if(count($lessonPlans) === 0)
        <div class="text-gray-500">
            Belum ada lesson plan untuk kelas ini.
        </div>
    @else

        <div class="space-y-4">
            @foreach($lessonPlans as $item)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ $item['teacher_name'] }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y H:i') }}
                            </p>
                        </div>

                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">
                            Meeting ID: {{ $item['meeting_id'] }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        {{ $item['lesson_plan'] }}
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection