<aside
    class="bg-gradient-to-b from-slate-800 to-teal-900 text-gray-200 border-r border-slate-700 w-64
           fixed inset-y-0 left-0 z-30 transform transition-transform duration-300 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="flex flex-col h-full overflow-hidden">
        {{-- Header Sidebar --}}
        <div class="px-4 py-5 border-b border-slate-700 text-center flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-lg font-semibold text-white">ADMIN PORTAL</h2>
                <p class="text-xs text-gray-400">Project Approval</p>
            </a>
        </div>

        {{-- Daftar Proyek --}}
        <div class="flex-1 overflow-y-auto px-2 py-4">
            
            <div class="md:hidden px-2">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900' : '' }}">
                            <span class="font-medium text-sm">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition hover:bg-slate-700 {{ request()->routeIs('admin.users.*') ? 'bg-slate-900' : '' }}">
                            <span class="font-medium text-sm">Kelola User</span>
                        </a>
                    </li>
                </ul>
                <hr class="my-4 border-slate-700">
            </div>

            <p class="px-2 pb-2 text-xs font-semibold text-gray-400 uppercase">Review Proyek</p>
            <ul class="space-y-1">
                @forelse ($projectsForReview as $project)
                    @php
                        $type = $project instanceof \App\Models\PengadaanTanah ? 'pengadaan-tanah' : 'row';
                        $route = route('admin.projects.show', ['type' => $type, 'id' => $project->id]);
                        $isActive = request()->is('admin/projects/' . $type . '/' . $project->id);
                    @endphp
                    <li>
                        <a href="{{ $route }}" class="flex items-center justify-between gap-3 px-3 py-2 rounded-md transition {{ $isActive ? 'bg-slate-900' : 'hover:bg-slate-700' }}">
                            <div class="flex items-center gap-3">
                                <span class="h-2 w-2 rounded-full flex-shrink-0 {{ $type === 'pengadaan-tanah' ? 'bg-blue-500' : 'bg-green-500' }}"></span>
                                <span class="font-medium text-sm truncate {{ $isActive ? 'text-white' : 'text-gray-300' }}">{{ $project->nama_proyek }}</span>
                            </div>
                            @if(!$project->is_viewed)
                                <span class="bg-yellow-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">Baru</span>
                            @endif
                        </a>
                    </li>
                @empty
                    <li>
                        <p class="px-3 py-2 text-sm text-gray-500">Tidak ada proyek untuk direview.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- Tombol Logout --}}
        <div class="px-4 py-4 border-t border-gray-600 flex-shrink-0">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-3 py-2 text-gray-300 rounded-md hover:bg-red-900 hover:text-white transition">
                    <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 8V6C14 4.89543 13.1046 4 12 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H12C13.1046 20 14 19.1046 14 18V16M10 12H20M20 12L17 9M20 12L17 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>