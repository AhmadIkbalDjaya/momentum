<div>
  {{-- Success is as dangerous as failure. --}}
  <nav class="bg-gray-100 px-3 pt-0 pb-3 rounded-md w-full text-gray-500 font-normal">
    <ol class="list-reset flex">
      <li>
        <a wire:navigate href="{{ route('home') }}" class="text-gray-500 text-nowrap">
          Home
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a wire:navigate href="{{ route('quiz.index') }}" class="text-gray-500 text-nowrap">
          Quiz
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a wire:navigate href="{{ route('quiz.show', ['quiz' => $quiz->id]) }}" class="text-gray-500 text-nowrap">
          {{ $quiz->name }}
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a class="text-gray-500 text-nowrap">
          Kerjakan Quiz
        </a>
      </li>
    </ol>
  </nav>

  <div class="">
    <h1 class="text-momentum1 font-bold px-3">{{ $quiz->name }}</h1>
    <div class="flex flex-wrap md:flex-nowrap justify-between gap-x-5 gap-y-3 mt-5">
      @if (count($quiz->questions) > 0)
        <div class="basis-full md:basis-8/12 bg-white shadow-sm rounded-lg p-6">
          <h6 class="font-medium text-base">Nomor {{ $active_question }}</h6>
          @foreach ($quiz->questions as $index => $question)
            @if ($loop->iteration == $active_question)
              <div class="block">
                <div class="">
                  {!! $question->question !!}
                  <div class="clear-left block"></div>
                </div>
                @if ($quiz->quiz_type_id != 3)
                  <div class="my-2 block w-full box-border">
                    <form action="">
                      @foreach ($question->options as $option)
                        <div class="flex items-start gap-1 py-3">
                          <input type="radio" wire:model="selected_options.{{ $index }}"
                            wire:click="updateAnswer" name="question{{ $question->id }}options"
                            value="{{ $option->id }}" id="selected_options{{ $option->id }}" class="mt-2">
                          <label for="selected_options{{ $option->id }}" class="flex">
                            <p class="me-2">
                              @if ($loop->iteration == 1)
                                A.
                              @elseif($loop->iteration == 2)
                                B.
                              @elseif($loop->iteration == 3)
                                C.
                              @elseif($loop->iteration == 4)
                                D.
                              @elseif($loop->iteration == 5)
                                E.
                              @endif
                            </p>
                            <div>
                              {!! $option->option !!}
                            </div>
                          </label>
                        </div>
                      @endforeach
                    </form>
                  </div>
                  <div class="clear-left block"></div>
                @endif
              </div>
            @endif
          @endforeach
          <div class="flex {{ $active_question > 1 ? 'justify-between' : 'justify-end' }} mt-10 block w-full">
            @if ($active_question > 1)
              <button wire:click="setActiveQuestion('previous')" class="px-3 py-1 rounded bg-momentum1 text-white">
                <i class="fa-solid fa-arrow-left"></i>
                Sebelumnya
              </button>
            @endif
            @if ($active_question != $quiz->questions->count())
              <button wire:click="setActiveQuestion('next')" class="px-3 py-1 rounded bg-momentum1 text-white">
                Selanjutnya
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            @endif
            @if ($quiz->quiz_type_id != 3)
              @if ($active_question == $quiz->questions->count())
                @if ($all_answered == true)
                  <button wire:click='submit_quiz' class="px-3 py-1 rounded bg-momentum1 text-white">
                    Kumpulkan
                    <i class="fa-solid fa-arrow-right"></i>
                  </button>
                @elseif ($all_answered == false)
                  <span class="text-xs text-red-400">
                    Semua pertanyaan belum terjawab
                  </span>
                @endif
              @endif
            @endif
          </div>
        </div>
      @else
        <div class="basis-full md:basis-8/12 bg-white shadow-sm rounded-lg p-6">
          <div class="grid place-items-center">
            <img src="{{ asset('images/icons/out-of-stock.webp') }}" class="h-16" alt="" srcset="">
            <p class="font-medium text-gray-400 mt-2">Soal belum tersedia</p>
          </div>
        </div>
      @endif
      <div class="basis-full md:basis-4/12">
        <div class="bg-white shadow-sm rounded-lg pb-5">
          <h6 class="px-5 py-2 bg-gray-200 rounded-t-lg font-medium">Daftar Soal</h6>
          <div class="px-6 py-6">
            <div class="grid gap-2 grid-cols-5 justify-between">
              @foreach ($quiz->questions as $index => $question)
                <button wire:click="setActiveQuestion('set', {{ $loop->iteration }})"
                  class="{{ $loop->iteration == $active_question ? 'bg-momentum1' : ($selected_options[$index] != null ? 'bg-momentum2' : 'bg-gray-500') }} px-2 py-1 text-white font-medium rounded">
                  {{ $loop->iteration }}
                </button>
              @endforeach
            </div>
          </div>
          <livewire:user.components.time-remaining :quiz_end_time="$quiz->end_time" :start_time_work="$student_quiz->start_time" :duration="$quiz->duration" />
          <livewire:user.components.user-online-component :quiz="$quiz" :student_quiz_id="$student_quiz->id" :answered_count="$answered_count"
            :start_time_work="$student_quiz->start_time" />
          <div class="px-6 mt-2 flex gap-x-2">
            <div class="flex gap-x-1 items-center">
              <div class="h-3 w-3 bg-momentum1 rounded">
              </div>
              <p class="text-xs">Dilihat</p>
            </div>
            @if ($quiz->quiz_type_id != 3)
              <div class="flex gap-x-1 items-center">
                <div class="h-3 w-3 bg-momentum2 rounded">
                </div>
                <p class="text-xs">Terjawab</p>
              </div>
              <div class="flex gap-x-1 items-center">
                <div class="h-3 w-3 bg-gray-500 rounded">
                </div>
                <p class="text-xs">Belum Dijawab</p>
              </div>
            @endif
          </div>
          @if ($quiz->quiz_type_id == 3)
            <div class="px-6 mt-3">
              <form action="" wire:submit="submit_essay_quiz" enctype="multipart/form-data">
                <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">
                  Upload Jawaban Anda (pdf)
                </label>
                <input type="file" wire:model="essay_answer_file" name="essay_answer_file"
                  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                  id="" accept=".pdf">
                @error('essay_answer_file')
                  <livewire:components.input-error-message field="essay_answer_file" />
                @enderror
                <button type="submit" class="bg-momentum1 text-white w-full rounded px-5 py-1 mt-2">
                  Kumpul dan Selesaikan
                </button>
              </form>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
