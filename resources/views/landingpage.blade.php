<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>D-LANDROW</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Figtree', 'Montserrat', sans-serif;
        }
        /* Style tambahan untuk transisi modal */
        .modal-enter { opacity: 0; }
        .modal-enter-active { opacity: 1; transition: opacity 300ms; }
        .modal-leave { opacity: 1; }
        .modal-leave-active { opacity: 0; transition: opacity 300ms; }

        .modal-content-enter { opacity: 0; transform: scale(0.95); }
        .modal-content-enter-active { opacity: 1; transform: scale(1); transition: all 300ms; }
        .modal-content-leave { opacity: 1; transform: scale(1); }
        .modal-content-leave-active { opacity: 0; transform: scale(0.95); transition: all 300ms; }
    </style>
</head>
<body class="relative h-screen overflow-hidden">

    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bg-landing.png') }}');"></div>

    <img src="{{ asset('images/logo-bumn.png') }}" alt="BUMN" class="absolute top-6 left-6 w-40 md:w-32">
    <img src="{{ asset('images/logo-pln.png') }}" alt="PLN" class="absolute top-6 right-6 w-20 md:w-16">

    <div class="absolute bottom-6 left-6 flex space-x-4">
        <img src="{{ asset('images/pln-mobile-logo.png') }}" alt="PLN Mobile" class="w-28 md:w-22">
        <img src="{{ asset('images/logo-akhlak.png') }}" alt="AKHLAK" class="w-28 md:w-22">
    </div>

    <div class="relative z-10 h-full flex items-center justify-end pr-[10vw] md:pr-[5vw]">
        <div class="text-right transform -translate-y-20 md:-translate-y-12 mr-16 md:mr-8" style="font-family: 'Montserrat', sans-serif;">
            <h1 class="text-6xl md:text-5xl font-extrabold italic text-[#0a3a4a] drop-shadow-lg">
                D-LANDROW
            </h1>
            <p class="text-lg md:text-base uppercase tracking-widest text-[#0a3a4a] mt-2">
                SISTEM DIGITALISASI PENGADAAN TANAH & ROW
            </p>
            <button onclick="openLoginModal()"
               class="inline-block mt-6 px-8 py-3 bg-[#0a3a4a] text-white font-semibold rounded-full shadow-lg border-b-4 border-white hover:bg-[#082f3b] transition">
                Login
            </button>
        </div>
    </div>

    <div id="loginModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden modal-enter">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-8 m-4 modal-content-enter">
            
            <div class="flex justify-end">
                <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN" class="w-20 h-auto">
            </div>

            <div class="flex justify-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Masuk ke D-LANDROW</h2>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- PERUBAHAN: Mengganti input IAM menjadi Email --}}
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full border border-teal-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 placeholder:font-light placeholder:text-gray-400" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" class="block w-full mt-1 border border-teal-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 placeholder:font-light placeholder:text-gray-400"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" placeholder="**********" />
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                            <svg id="eyeIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eyeSlashIcon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L6.228 6.228" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div> --}}
                
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const loginModal = document.getElementById('loginModal');

        function openLoginModal() {
            loginModal.classList.remove('hidden');
            loginModal.classList.add('flex');
            loginModal.firstElementChild.classList.remove('modal-content-leave', 'modal-content-leave-active');
            loginModal.classList.remove('modal-leave', 'modal-leave-active');
            loginModal.firstElementChild.classList.add('modal-content-enter-active');
            loginModal.classList.add('modal-enter-active');
        }

        function closeLoginModal() {
            loginModal.firstElementChild.classList.remove('modal-content-enter', 'modal-content-enter-active');
            loginModal.classList.remove('modal-enter', 'modal-enter-active');
            loginModal.firstElementChild.classList.add('modal-content-leave-active');
            loginModal.classList.add('modal-leave-active');

            setTimeout(() => {
                loginModal.classList.add('hidden');
                loginModal.classList.remove('flex');
            }, 300); 
        }

        loginModal.addEventListener('click', function(event) {
            if (event.target === loginModal) {
                closeLoginModal();
            }
        });

        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>
