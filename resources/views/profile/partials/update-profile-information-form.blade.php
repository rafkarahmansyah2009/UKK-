<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Upload & Preview -->
        <div x-data="{ photoName: null, photoPreview: null }">
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Foto Profil</label>
            <div class="flex items-center gap-5">
                <!-- Current or Preview Avatar -->
                <div class="relative">
                    <template x-if="!photoPreview">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 font-bold text-xl flex items-center justify-center border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </template>
                    <template x-if="photoPreview">
                        <span class="block w-20 h-20 rounded-full bg-cover bg-no-repeat bg-center border-2 border-blue-500 shadow-sm"
                              :style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </template>
                </div>

                <div class="space-y-1">
                    <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*"
                           x-ref="photo"
                           x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                           ">
                    <button type="button" x-on:click.prevent="$refs.photo.click()" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition">
                        Pilih Foto Baru
                    </button>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, WEBP (Maksimal 2MB)</p>
                    <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon / WhatsApp')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" placeholder="08123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 font-medium"
                >{{ __('Profil berhasil diperbarui.') }}</p>
            @endif
        </div>
    </form>
</section>
