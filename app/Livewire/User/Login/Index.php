<?php

namespace App\Livewire\User\Login;

use App\Models\Student;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.app')]

    #[Validate('required')]
    public $username;

    #[Validate('required|min:8')]
    public $password;
    public $quotes = [
        [
            'quote' => 'Belajar adalah proses seumur hidup yang tidak pernah berhenti. Setiap pengalaman baru adalah kesempatan untuk memperluas wawasan dan meningkatkan diri.',
            'name' => 'Albert Einstein',
        ],
        [
            'quote' => 'Pengetahuan adalah harta yang paling berharga, dan belajar adalah kunci untuk membuka pintu kekayaan tersebut. Jangan pernah berhenti mengejar ilmu.',
            'name' => 'Nelson Mandela',
        ],
        [
            'quote' => 'Setiap kali kita belajar sesuatu yang baru, kita menambah satu batu bata lagi ke pondasi masa depan kita. Belajar adalah investasi terbaik yang bisa kita lakukan.',
            'name' => 'Benjamin Franklin',
        ],
        [
            'quote' => 'Belajar bukan hanya tentang memahami buku teks, tetapi juga tentang memahami dunia di sekitar kita dan bagaimana kita bisa berkontribusi lebih baik.',
            'name' => 'Malala Yousafzai',
        ],
        [
            'quote' => 'Orang yang bijak akan selalu mencari kesempatan untuk belajar, karena mereka tahu bahwa pengetahuan adalah kekuatan yang tidak ternilai harganya.',
            'name' => 'Socrates',
        ],
        [
            'quote' => 'Belajar adalah jendela menuju dunia yang lebih besar dan lebih luas. Dengan belajar, kita bisa melihat lebih jauh dan mencapai lebih tinggi.',
            'name' => 'Oprah Winfrey',
        ],
        [
            'quote' => 'Kesuksesan dalam hidup seringkali datang dari kemampuan untuk terus belajar dan beradaptasi dengan perubahan. Jangan pernah berhenti belajar.',
            'name' => 'Charles Darwin',
        ],
        [
            'quote' => 'Setiap tantangan yang kita hadapi adalah kesempatan untuk belajar sesuatu yang baru. Jangan takut gagal, karena dari kegagalan kita belajar untuk berhasil.',
            'name' => 'Thomas Edison',
        ],
        [
            'quote' => 'Belajar adalah perjalanan tanpa akhir. Setiap langkah membawa kita lebih dekat ke tujuan kita, tetapi juga membuka pintu ke lebih banyak pengetahuan.',
            'name' => 'Mahatma Gandhi',
        ],
        [
            'quote' => 'Dalam dunia yang terus berubah, kemampuan untuk belajar dan berinovasi adalah kunci untuk bertahan dan berkembang. Jadilah pembelajar seumur hidup.',
            'name' => 'Steve Jobs',
        ],
    ];

    public function render()
    {
        return view('livewire.user.login.index', [
            'quote' => $this->quotes[rand(0, 9)],
        ])->title('Login');
    }

    public function login()
    {
        $this->validate();
        $student = Student::where('username', $this->username)->first();
        if ($student && Hash::check($this->password, $student->password)) {
            Auth::guard('student')->login($student);
            return $this->redirectRoute('home', navigate: true);
        }
        $this->reset();
        flash('Username / Password Salah', 'danger');
    }
}
