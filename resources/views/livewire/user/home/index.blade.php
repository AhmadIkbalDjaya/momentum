<div class="flex flex-col gap-y-5">
  <div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <div
      class="flex flex-col gap-5 p-5 md:flex-row md:items-center md:justify-between"
    >
      <div class="flex min-w-0 items-center gap-4">
        <img
          src="{{ asset("images/man2.webp") }}"
          alt="{{ $auth["name"] }}"
          srcset=""
          class="bg-primary h-20 w-20 shrink-0 rounded-lg object-cover md:h-28 md:w-28"
        />
        <div class="min-w-0">
          <p class="text-xs font-bold text-gray-400 uppercase">
            Selamat Datang
          </p>
          <h6 class="text-primary mt-1 truncate text-xl font-bold md:text-2xl">
            {{ $auth["name"] }}
          </h6>
          <p class="mt-1 truncate text-sm font-medium text-gray-500">
            {{ $auth["school"] }}
          </p>
          <a
            wire:navigate
            href="{{ route("profile") }}"
            class="text-primary mt-3 inline-flex items-center gap-x-1 text-sm font-bold"
          >
            <x-icons.user class="h-4 w-4" />
            <span>Lihat Profil</span>
          </a>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:min-w-80">
        <div
          class="flex items-center gap-3 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2.5"
        >
          <div
            class="text-primary bg-primary/10 grid h-9 w-9 shrink-0 place-items-center rounded-md"
          >
            <x-icons.flag class="h-5 w-5" />
          </div>
          <div class="min-w-0">
            <h6 class="text-primary text-xl leading-none font-bold">
              {{ $auth["quiz_count"] }}
            </h6>
            <p class="mt-1 truncate text-xs font-medium text-gray-500">
              Quiz Diselesaikan
            </p>
          </div>
        </div>
        <div
          class="flex items-center gap-3 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2.5"
        >
          <div
            class="text-primary bg-primary/10 grid h-9 w-9 shrink-0 place-items-center rounded-md"
          >
            <x-icons.circle-check class="h-5 w-5" />
          </div>
          <div class="min-w-0">
            <h6 class="text-primary text-xl leading-none font-bold">
              {{ $auth["answer_count"] }}
            </h6>
            <p class="mt-1 truncate text-xs font-medium text-gray-500">
              Soal Dijawab
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="rounded-lg bg-white p-5 shadow-sm">
    <div class="mb-2.5 flex items-center justify-between">
      <div class="text-primary flex items-center gap-x-1">
        <x-icons.stack-2 class="h-5 w-5" />
        <h1 class="font-bold">Quiz Tersedia</h1>
      </div>
      @if (count($quizzes) > 0)
        <a
          wire:navigate
          href="{{ route("quiz.index") }}"
          class="text-primary hidden items-center gap-x-1 text-sm font-medium md:flex"
        >
          <span>Lihat Semua</span>
          <x-icons.angle-right class="h-3.5 w-3.5" />
        </a>
      @endif
    </div>
    @if (count($quizzes) > 0)
      <div class="grid grid-cols-1 justify-between gap-3 py-3 md:grid-cols-3">
        @foreach ($quizzes as $quiz)
          <livewire:user.components.quiz-card :quiz="$quiz" />
        @endforeach
      </div>
      @if (count($quizzes) > 0)
        <a
          wire:navigate
          href="{{ route("quiz.index") }}"
          class="text-primary flex items-center justify-end gap-x-1 text-sm font-medium md:hidden"
        >
          <span>Lihat Semua</span>
          <x-icons.angle-right class="h-3.5 w-3.5" />
        </a>
      @endif
    @else
      <div class="grid grid-cols-1 place-items-center gap-2 py-5">
        <div class="grid place-items-center">
          <img
            src="{{ asset("images/icons/out-of-stock.webp") }}"
            class="h-16"
            alt="Empty Quiz"
            srcset=""
          />
          <p class="mt-2 font-medium text-gray-400">
            Belum Ada Quiz Yang Tersedia
          </p>
        </div>
      </div>
    @endif
  </div>

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-7">
    <div class="rounded-lg bg-white shadow-sm lg:col-span-4">
      <div
        class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 px-4 py-4"
      >
        <div class="text-primary flex items-center gap-x-2">
          <x-icons.clock-rotate-left class="h-5 w-5" />
          <h1 class="font-bold">Riwayat Terakhir</h1>
        </div>
        @if (count($student_quizzes) > 0)
          <a
            wire:navigate
            href="{{ route("quiz.history") }}"
            class="text-primary flex items-center gap-x-1 text-sm font-bold"
          >
            <span>Lihat Semua</span>
            <x-icons.angle-right class="h-3.5 w-3.5" />
          </a>
        @endif
      </div>

      @if (count($student_quizzes) > 0)
        <div>
          @foreach ($student_quizzes as $student_quiz)
            <livewire:user.components.quiz-history-row
              :student_quiz="$student_quiz"
              :compact="true"
            />
          @endforeach
        </div>
      @else
        <div class="grid min-h-32 place-items-center px-4 py-6">
          <div class="grid place-items-center">
            <img
              src="{{ asset("images/icons/out-of-stock.webp") }}"
              class="h-16"
              alt="Empty Quiz"
              srcset=""
            />
            <p class="mt-2 text-sm font-medium text-gray-400">
              Belum Ada Quiz Yang Dikerjakan
            </p>
          </div>
        </div>
      @endif
    </div>

    <div
      x-data="{
        activeTip: 0,
        timer: null,
        tips: [
          {
            title: 'Atur Waktu Belajar',
            text: 'Buat jadwal singkat setiap hari agar materi lebih mudah diingat.',
          },
          {
            title: 'Kerjakan Quiz Rutin',
            text: 'Latihan berkala membantu kamu memahami pola soal dan mengukur progres.',
          },
          {
            title: 'Review Hasil Quiz',
            text: 'Lihat kembali jawaban dan nilai untuk menemukan bagian yang perlu diperbaiki.',
          },
        ],
        start() {
          this.stop()
          this.timer = setInterval(() => {
            this.activeTip = (this.activeTip + 1) % this.tips.length
          }, 3500)
        },
        stop() {
          clearInterval(this.timer)
        },
      }"
      x-init="start()"
      @mouseenter="stop()"
      @mouseleave="start()"
      class="rounded-lg bg-white p-4 shadow-sm lg:col-span-3"
    >
      <div class="text-primary flex items-center gap-x-2">
        <x-icons.star class="h-5 w-5" />
        <h1 class="font-bold">Tips Belajar</h1>
      </div>
      <div class="flex items-center">
        <img
          src="{{ asset("images/learning-tips.svg") }}"
          alt="Tips Belajar"
          class="h-20 w-20 shrink-0 object-contain sm:h-30 sm:w-fit"
        />
        <div class="min-w-0">
          <p
            class="text-primary text-sm font-bold"
            x-text="tips[activeTip].title"
          ></p>
          <p
            class="mt-1 text-sm leading-relaxed font-medium text-gray-600"
            x-text="tips[activeTip].text"
          ></p>
        </div>
      </div>
      <div class="mt-3 flex justify-center gap-1.5">
        <template x-for="(tip, index) in tips" :key="tip.title">
          <button
            type="button"
            @click="activeTip = index"
            x-bind:class="activeTip === index ? 'bg-primary w-5' : 'bg-gray-300 w-2'"
            class="h-2 cursor-pointer rounded-full transition-all"
          ></button>
        </template>
      </div>
    </div>
  </div>
</div>
