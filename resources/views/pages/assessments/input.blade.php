@extends('layouts.main')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-white">Input Assessment for {{ $student['name'] ?? 'Student' }}</h2>
    <form action="{{ route('assessments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student['id'] }}">
        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Mapel</label>
            <select name="subject" id="subject" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required>
                <option value="Bahasa inggris">Bahasa inggris</option>
                <option value="Matik">Matik</option>
                <option value="Ipas">Ipas</option>
                <option value="Pancasila">Pancasila</option>
                <option value="Bahasa indo">Bahasa indo</option>
                <option value="Agama">Agama</option>
                <option value="Bahasa bali">Bahasa bali</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis Ulangan</label>
            <select name="type" id="type" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required>
                <option value="Ulangan Harian">Ulangan Harian</option>
                <option value="Try Out">Try Out</option>
               
            </select>
        </div>
        <div class="mb-4">
            <label for="score" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Score</label>
            <input type="number" name="score" id="score" min="1" max="10" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required>
            <p class="text-xs text-red-600 mt-1">* Nilai hanya boleh 1-10</p>
        </div>
        <div class="mb-4">
            <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Remarks (optional)</label>
            <textarea name="remarks" id="remarks" rows="3" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Additional remarks (optional)"></textarea>
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Assessment</button>
    </form>
</div>
@endsection