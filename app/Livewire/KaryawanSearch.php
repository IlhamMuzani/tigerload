<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Karyawan;
use Livewire\WithPagination;

class KaryawanSearch extends Component
{
    use WithPagination;

    public $search;
    public $page = 1;

    protected $updatesQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']],
    ];

    protected $listeners = [
        'studentAdded',
    ];

    public function studentAdded()
    {
        # code...
    }

    public function render()
    {
        $karyawans = Karyawan::latest()->paginate(5);

        if ($this->search !== null) {
            $karyawans = Karyawan::where('nama_lengkap', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(5);
        }

        return view('livewire.karyawan-search',  [
            'karyawans' => $karyawans,
        ]);
    }
}