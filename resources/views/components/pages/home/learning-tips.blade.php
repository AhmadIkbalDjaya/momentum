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
