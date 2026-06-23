<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow-sm">
  <form wire:submit="checkCode">
    <div class="mb-5 text-center">
      <div
        class="text-primary bg-primary/10 mx-auto mb-4 grid h-12 w-12 place-items-center rounded-md"
      >
        <x-icons.lock class="h-5 w-5" />
      </div>
      <h1 class="text-primary text-xl font-bold">Masukkan Kode Quiz</h1>
      <p class="mt-2 text-sm font-medium text-gray-500">
        Gunakan kode yang diberikan untuk mulai mengerjakan quiz.
      </p>
    </div>

    <div>
      <label class="mb-2 block text-sm font-bold text-gray-700">
        Kode Quiz
      </label>
      <input
        wire:model="quiz_code"
        wire:input="clearValidation('quiz_code')"
        type="text"
        class="focus:outline-primary block w-full rounded-md border border-gray-300 bg-gray-50 p-3 text-center text-lg font-bold tracking-wide text-gray-900 uppercase"
        placeholder="Kode Quiz"
      />
      <div class="px-1">
        <x-input-error-message name="quiz_code" />
      </div>
    </div>

    <button
      type="submit"
      class="btn btn-primary mt-5 w-full rounded-md px-4 py-2.5 text-sm"
    >
      <x-loading-icon target="checkCode" />
      Mulai
    </button>
  </form>
</div>
