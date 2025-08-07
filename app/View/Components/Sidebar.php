<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\PengadaanTanah;
use App\Models\Row;

class Sidebar extends Component
{
    /**
     * Properti publik untuk menampung data proyek.
     * Variabel ini akan otomatis tersedia di file sidebar.blade.php.
     */
    public $pengadaanTanahProjects;
    public $rowProjects;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->pengadaanTanahProjects = PengadaanTanah::latest()->get();
        $this->rowProjects = Row::latest()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}