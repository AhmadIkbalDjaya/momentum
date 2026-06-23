<div class="flex flex-col gap-y-5">
  <x-pages.home.profile-card :auth="$auth" />

  <x-pages.home.available-quizzes :quizzes="$quizzes" />

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-7">
    <x-pages.home.recent-history :student_quizzes="$student_quizzes" />

    <x-pages.home.learning-tips />
  </div>
</div>
