{{-- quiz code modal --}}
<div
  x-cloak
  x-show="show_code_modal"
  @click="closeCodeModal()"
  x-transition.opacity
  class="fixed inset-0 z-20 flex items-end justify-center bg-gray-900/50 p-0 sm:items-center sm:p-4"
>
  <div
    @click.stop
    x-transition
    class="w-full rounded-t-xl bg-white p-5 shadow-lg sm:max-w-md sm:rounded-xl"
  >
    <form @submit.prevent="$wire.checkCode(quiz_code)">
      <div class="mb-4 flex items-start justify-between gap-3">
        <div>
          <h2 class="text-primary text-xl font-bold">Masukkan Kode Quiz</h2>
          <p class="mt-1 text-sm font-medium text-gray-500">
            Gunakan kode yang diberikan untuk memulai quiz.
          </p>
        </div>
        <button
          type="button"
          @click="closeCodeModal()"
          class="grid h-9 w-9 shrink-0 cursor-pointer place-items-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200"
        >
          <x-icons.x class="h-4 w-4" />
        </button>
      </div>
      <div class="mb-2">
        <label class="mb-2 block text-sm font-bold text-gray-700">
          Kode Quiz
        </label>
        <input
          x-model="quiz_code"
          type="text"
          class="focus:outline-primary block w-full rounded-md border border-gray-300 bg-gray-50 p-3 text-center text-lg font-bold tracking-wide text-gray-900 uppercase"
          placeholder="Kode Quiz"
        />
        <div class="px-1">
          <x-input-error-message name="quiz_code" />
        </div>
      </div>
      <div class="mt-5 grid grid-cols-2 gap-3">
        <button
          @click="closeCodeModal()"
          type="button"
          class="cursor-pointer rounded-md bg-gray-100 px-4 py-2.5 text-center text-sm font-bold text-gray-600 hover:bg-gray-200"
        >
          Tutup
        </button>
        <button
          type="submit"
          class="btn btn-primary rounded-md px-4 py-2.5 text-sm"
        >
          <x-loading-icon target="checkCode" />
          Mulai
        </button>
      </div>
    </form>
  </div>
</div>
