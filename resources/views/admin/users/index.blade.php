<x-app-layout>
    <x-slot name="header">
        <x-content-header :title="__('Kelola Pengguna')">
            <x-slot name="actions">
                <button id="btn-tambah-user" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">
                    + Tambah User
                </button>
            </x-slot>
        </x-content-header>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Menampilkan notifikasi sukses/error --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-200 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                          <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-md">
                              {{ session('error') }}
                          </div>
                    @endif

                    <div class="flex justify-end mb-4">
                        <button id="btn-tambah-user" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">
                            + Tambah User
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Role</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button class="btn-edit-user text-indigo-600 hover:text-indigo-900" 
                                                        data-id="{{ $user->id }}"
                                                        data-url="{{ route('admin.users.update', $user->id) }}"
                                                        data-nama="{{ $user->name }}"
                                                        data-email="{{ $user->email }}"
                                                        data-role="{{ $user->role }}"
                                                        title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </button>

                                                @if(auth()->id() != $user->id)
                                                    <form class="form-hapus" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" data-nama="{{ $user->name }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" /></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengguna.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UNTUK TAMBAH/EDIT USER --}}
    <div id="user-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 id="modal-title" class="text-2xl font-bold"></h3>
                <button id="btn-tutup-modal" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
            </div>
            <div class="mt-5">
                <form id="user-form" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" id="form-method">
                    <input type="hidden" id="user_id_input" name="user_id">
                    
                    <!-- Nama -->
                    <div>
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full @error('name') @enderror" :value="old('name')" required autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full @error('email') @enderror" :value="old('email')" required autocomplete="email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Role -->
                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('role') @enderror" required>
                            <option value="user" @if(old('role') == 'user') selected @endif>User</option>
                            <option value="admin1" @if(old('role') == 'admin1') selected @endif>Admin 1</option>
                            <option value="admin2" @if(old('role') == 'admin2') selected @endif>Admin 2</option>
                            <option value="admin3" @if(old('role') == 'admin3') selected @endif>Admin 3</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label id="password-label" for="password" class="block font-medium text-sm text-gray-700">Password</label>
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <button type="button" id="btn-batal-modal" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                        <x-primary-button type="submit">{{ __('Simpan') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('user-modal');
            const userForm = document.getElementById('user-form');
            
            if (!modal || !userForm) {
                console.error('Elemen modal atau form tidak ditemukan!');
                return; 
            }
            
            const modalTitle = document.getElementById('modal-title');
            const formMethod = document.getElementById('form-method');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordLabel = document.getElementById('password-label');

            const openModal = () => modal.classList.remove('hidden');
            const closeModal = () => modal.classList.add('hidden');

            document.getElementById('btn-tutup-modal').addEventListener('click', closeModal);
            document.getElementById('btn-batal-modal').addEventListener('click', closeModal);
            
            // --- FUNGSI TOMBOL TAMBAH USER ---
            const btnTambah = document.getElementById('btn-tambah-user');
            if (btnTambah) {
                btnTambah.addEventListener('click', function() {
                    userForm.reset();
                    userForm.action = "{{ route('admin.users.store') }}";
                    formMethod.value = "POST";
                    modalTitle.textContent = "Tambah Pengguna Baru";
                    if(passwordLabel) passwordLabel.textContent = "Password";
                    if(passwordInput) passwordInput.required = true;
                    if(passwordConfirmationInput) passwordConfirmationInput.required = true;
                    document.getElementById('user_id_input').value = ''; 
                    openModal();
                });
            }

            // --- FUNGSI TOMBOL EDIT USER ---
            document.querySelectorAll('.btn-edit-user').forEach(button => {
                button.addEventListener('click', function() {
                    userForm.reset();
                    userForm.action = this.dataset.url;
                    formMethod.value = "PUT";
                    modalTitle.textContent = `Ubah Informasi Akun: ${this.dataset.nama}`;
                    
                    document.getElementById('name').value = this.dataset.nama;
                    document.getElementById('email').value = this.dataset.email;
                    document.getElementById('role').value = this.dataset.role;

                    if(passwordLabel) passwordLabel.textContent = "Password Baru (Opsional)";
                    if(passwordInput) passwordInput.required = false;
                    if(passwordConfirmationInput) passwordConfirmationInput.required = false;
                    document.getElementById('user_id_input').value = this.dataset.id;
                    openModal();
                });
            });

            // --- FUNGSI FORM HAPUS DENGAN SWEETALERT ---
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let nama = this.dataset.nama;
                    Swal.fire({
                        title: 'Anda Yakin?',
                        html: `User dengan nama <strong>${nama}</strong> akan dihapus secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
            const oldUserId = "{{ old('user_id') }}";

            if (hasErrors) {
                if (oldUserId) {
                    const userButton = document.querySelector(`.btn-edit-user[data-id='${oldUserId}']`);
                    let userName = userButton ? userButton.dataset.nama : '';

                    modalTitle.textContent = `Ubah Informasi Akun: ${userName}`;
                    
                    let updateUrl = "{{ route('admin.users.update', ':id') }}";
                    userForm.action = updateUrl.replace(':id', oldUserId);
                    
                    formMethod.value = "PUT";
                    passwordLabel.textContent = "Password Baru (Opsional)";
                    passwordInput.required = false;
                    passwordConfirmationInput.required = false;

                    openModal();
                } 
                else {
                    if(btnTambah) btnTambah.click();
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
