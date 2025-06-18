<!-- resources/views/components/sidebar.blade.php -->
<aside class="w-64 h-screen bg-white border-r flex flex-col">
    <!-- Sidebar Header -->
    <div class="px-6 py-4 border-b">
        <button 
            class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            New Project
        </button>
    </div>

    <!-- Sidebar Body -->
    <div class="flex-1 overflow-y-auto px-4 py-4">
        <!-- Example Project Folder 1 -->
        <details class="mb-2">
            <summary class="cursor-pointer flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100">
                <span>Project Alpha</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </summary>
            <ul class="pl-6 mt-2 space-y-1 text-sm text-gray-700">
                <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Overview</a></li>
                <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Tasks</a></li>
                <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Files</a></li>
            </ul>
        </details>

        <!-- Example Project Folder 2 -->
        <details class="mb-2">
            <summary class="cursor-pointer flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100">
                <span>Project Beta</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </summary>
            <ul class="pl-6 mt-2 space-y-1 text-sm text-gray-700">
                <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Overview</a></li>
                <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Tasks</a></li>
                <li><a href="#" class="block px-2 py-1 rounded hover:bg-gray-200">Files</a></li>
            </ul>
        </details>

        <!-- Add more folders dynamically in backend if needed -->
    </div>

    <!-- Sidebar Footer -->
    <div class="px-6 py-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
