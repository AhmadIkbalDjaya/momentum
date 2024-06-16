<div>
  {{-- Because she competes with no one, no one can compete with her. --}}
  <nav class="bg-gray-100 px-3 pt-0 pb-3 rounded-md w-full text-gray-500 font-normal">
    <ol class="list-reset flex">
      <li>
        <a href="{{ route('home') }}" class="text-gray-500">Home</a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a href="{{ route('quiz.index') }}" class="text-gray-500">Quiz</a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a class="text-gray-500">{{ $quiz->name }}</a>
      </li>
    </ol>
  </nav>

  <div class="bg-white shadow-sm rounded-lg p-6">
    <h1 class="text-momentum1 font-bold">Detail Quiz</h1>
    <div class="flex flex-wrap md:flex-nowrap gap-x-10 gap-y-3 mt-5">
      <div class="basis-full md:basis-7/12">
        <div class="h-60 md:h-72 w-full bg-no-repeat bg-cover bg-center rounded-md"
          style="background-image: url('{{ asset('images/quizzes/quiz-2.webp') }}')">
        </div>
        <p class="font-medium text-xl py-3">{{ $quiz->name }}</p>
      </div>
      <div class="basis-full md:basis-5/12">
        <div class="flex flex-col gap-y-5">
          <div class="flex">
            <div class="basis-6/12 font-medium text-gray-600">
              Jenis Quiz
            </div>
            <div class="basis-5/12 text-gray-500">
              {{ $quiz->quiz_type->description }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-6/12 font-medium text-gray-600">
              Tanggal Mulai
            </div>
            <div class="basis-5/12 text-gray-500">
              {{ date("d-m-Y H:i", strtotime($quiz->start_time)) }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-6/12 font-medium text-gray-600">
              Tanggal Selesai
            </div>
            <div class="basis-5/12 text-gray-500">
              {{ date("d-m-Y H:i", strtotime($quiz->end_time)) }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-6/12 font-medium text-gray-600">
              Durasi Pengerjaan
            </div>
            <div class="basis-5/12 text-gray-500">
              {{ $quiz->duration }} Menit
            </div>
          </div>
          <div class="flex">
            <div class="basis-6/12 font-medium text-gray-600">
              Status Pengerjaan
            </div>
            <div class="basis-5/12 text-gray-500">
              {{ $has_work ? 'Telah' : 'Belum' }} Dikerjakan
            </div>
          </div>
          @if ($has_work)
            <a href="{{ route('quiz.history') }}"
              class="bg-momentum1 text-white font-medium px-2 py-1 rounded w-full w-8/12 text-center">
              Lihat History Pengerjaan
            </a>
          @else
            <a href="{{ route('quiz.work', ['quiz' => $quiz->id]) }}"
              class="bg-momentum1 text-white font-medium px-2 py-1 rounded w-full w-8/12 text-center">
              Kerjakan Quiz
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
