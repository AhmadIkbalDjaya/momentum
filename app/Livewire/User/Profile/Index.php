<?php

namespace App\Livewire\User\Profile;

use App\Http\Resources\User\AuthProfileResource;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.base_layout')]

    #[Validate('required')]
    public $current_password;

    #[Validate('required|min:8|confirmed')]
    public $new_password;

    public $new_password_confirmation;

    public function render()
    {
        $authUser = Student::where('id', Auth::guard('student')->user()->id)
            ->select('id', 'name', 'username', 'gender', 'school_id')
            ->with([
                'school:id,name,school_category_id',
                'quizzes:id',
            ])
            ->withCount([
                'quizzes as quiz_count',
                'student_quiz_answers as answers_count' => function ($query) {
                    $query->whereHas('student_quiz', function ($subQuery) {
                        $subQuery->where('student_id', Auth::guard('student')->user()->id);
                    });
                },
            ])
            ->first();
        $auth = (new AuthProfileResource($authUser))->resolve();

        return view('livewire.user.profile.index', [
            'auth' => $auth,
        ])->title('Profile');
    }

    public function changePassword()
    {
        $auth = Auth::guard('student')->user();
        $this->validate();
        if ($this->current_password != $auth->password) {
            $this->reset();
            flash('Password Saat Ini Salah', 'danger');
        }
        $auth->update([
            'password' => $this->new_password,
        ]);
        $this->reset();
        flash('Password Berhasil di Ubah', 'success');
    }
}
