@extends('layouts.main')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-lg mt-8">
  <h2 class="text-xl font-semibold mb-4">Upload Bukti Repost</h2>

  @if(session('success'))
      <div class="bg-green-100 text-green-800 p-2 rounded mb-3">{{ session('success') }}</div>
  @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-2 rounded mb-3">{{ session('error') }}</div>
    @endif

  <form action="{{ route('repost-proofs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
     <input type="hidden" name="teacher_id" value="{{ session('teacher_id') }}">

      <div>
          <label class="block text-sm font-medium">File Bukti (jpg/png/pdf/mp4)</label>
          <input type="file" name="proof" class="border p-2 rounded w-full" required>
      </div>

      <button class="bg-blue-600 text-white px-4 py-2 rounded">Kirim</button>
  </form>
</div>
@endsection
