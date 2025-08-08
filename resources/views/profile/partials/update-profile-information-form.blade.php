<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Layout Grid Dua Kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Kolom Kiri --}}
            <div class="space-y-4">
                <div>
                    <x-input-label for="name" :value="('Fullname')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="nip" :value="('NIP')" />
                    <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full" :value="old('nip', $user->nip)" />
                    <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                </div>

                <div>
                    <x-input-label for="position" :value="('Position')" />
                    <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position', $user->position)" />
                    <x-input-error class="mt-2" :messages="$errors->get('position')" />
                </div>

                <div>
                    <x-input-label for="email" :value="('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    <x-input-label for="role" :value="('Role')" />
                    <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role', $user->role)" />
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-4">
                <div>
                    <x-input-label for="organization" :value="('Organization')" />
                    <x-text-input id="organization" name="organization" type="text" class="mt-1 block w-full" :value="old('organization', $user->organization)" />
                    <x-input-error class="mt-2" :messages="$errors->get('organization')" />
                </div>

                <div>
                    <x-input-label for="company" :value="('Company')" />
                    <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $user->company)" />
                    <x-input-error class="mt-2" :messages="$errors->get('company')" />
                </div>

                <div>
                    <x-input-label for="business_area" :value="('Business Area')" />
                    <x-text-input id="business_area" name="business_area" type="text" class="mt-1 block w-full" :value="old('business_area', $user->business_area)" />
                    <x-input-error class="mt-2" :messages="$errors->get('business_area')" />
                </div>

                <div>
                    <x-input-label for="personal_sub_area" :value="('Personal Sub Area')" />
                    <x-text-input id="personal_sub_area" name="personal_sub_area" type="text" class="mt-1 block w-full" :value="old('personal_sub_area', $user->personal_sub_area)" />
                    <x-input-error class="mt-2" :messages="$errors->get('personal_sub_area')" />
                </div>

                <div>
                    <x-input-label for="unit_organization" :value="('Unit Organization')" />
                    <x-text-input id="unit_organization" name="unit_organization" type="text" class="mt-1 block w-full" :value="old('unit_organization', $user->unit_organization)" />
                    <x-input-error class="mt-2" :messages="$errors->get('unit_organization')" />
                </div>
            </div>
        </div>


        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
