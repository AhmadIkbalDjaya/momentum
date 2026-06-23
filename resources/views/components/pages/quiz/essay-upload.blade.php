<div class="rounded-lg bg-white p-6 shadow-sm">
  <form action="" wire:submit="submit_essay_quiz" enctype="multipart/form-data">
    <label
      class="mb-2 block text-sm font-medium text-gray-900"
      for="file_input"
    >
      Upload Jawaban Anda (pdf)
    </label>
    <input
      type="file"
      wire:model="essay_answer_file"
      name="essay_answer_file"
      class="block w-full cursor-pointer rounded border border-gray-300 bg-gray-50 px-2 py-1 text-sm text-gray-900 focus:outline-none"
      id=""
      accept=".pdf"
    />
    <x-input-error-message name="essay_answer_file" />

    <button type="submit" class="btn btn-primary mt-2 w-full rounded px-5 py-1">
      <x-icons.floppy-disk class="h-5 w-5" />
      Kumpul dan Selesaikan
    </button>
  </form>
</div>
