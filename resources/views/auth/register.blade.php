<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Adınız')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
            <div class="col-6">
                <!-- Surname -->
                <div>
                    <x-input-label for="surname" :value="__('Soyadınız')" />
                    <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autofocus autocomplete="surname" />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
            </div>
        </div>
                <!-- Phone -->
                <div class="mb-3">
                    <x-input-label for="phone" :value="__('Telefonunuz')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Mailiniz')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        <div class="row">
            <div class="col-6">
                <!-- Gender -->
                <div class="mt-4">
                    <x-input-label for="gender" :value="__('Cinsiyetiniz')" />
                    <select id="gender" name="gender" class="block mt-1 w-full">
                        <option value="" disabled {{ old('gender') === null ? "selected" : "" }}>{{ __('Seçiniz') }}</option>
                        <option value="male" {{ old('gender') === "male" ? "selected" : "" }}>{{ __('Erkek') }}</option>
                        <option value="female" {{ old('gender') === "female" ? "selected" : "" }}>{{ __('Kadın') }}</option>
                        <option value="other" {{ old('gender') === "other" ? "selected" : "" }}>{{ __('Diğer') }}</option>
                    </select>

                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
            </div>
            <div class="col-6">
                <!-- Insurance Status -->
                <div class="mt-4">
                    <x-input-label for="insurance" :value="__('Sigorta Durumunuz')" />
                    <select id="insurance" name="insurance" class="block mt-1 w-full">
                        <option value="" disabled selected>{{ __('Seçiniz') }}</option>
                        @foreach($insurance_types as $insurance_type)
                            <option value="{{ $insurance_type->insurance_type_id }}"
                                {{ old('insurance') == $insurance_type->insurance_type_id ? "selected" : "" }}>
                                {{ __($insurance_type->insurance_type_name) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('insurance')" class="mt-2" />
                </div>
            </div>
        </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Şifreniz')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Tekrar Şifreniz')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Aramıza Katıldınız mı?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Kayıt Ol') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
