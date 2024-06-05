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

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <x-input-label for="firstname" :value="__('Firstname')" />
            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full" :value=" old('firstname', $user['firstname'])" required autofocus autocomplete="firstname" />
            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
        </div>

        <div>
            <x-input-label for="insertion" :value="__('Insertion')" />
            <x-text-input id="insertion" name="insertion" type="text" class="mt-1 block w-full" :value="old('insertion', $user['insertion'])" autofocus autocomplete="insertion" />
            <x-input-error class="mt-2" :messages="$errors->get('insertion')" />
        </div>

        <div>
            <x-input-label for="lastname" :value="__('Lastname')" />
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user['lastname'])" required autofocus autocomplete="lastname" />
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>


        

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user['phone'])" required autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user['address'])" required autofocus autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="huisnumber" :value="__('Huisnumber')" />
            <x-text-input id="huisnumber" name="huisnumber" type="text" class="mt-1 block w-full" :value="old('huisnumber', $user['huisnumber'])" required autofocus autocomplete="huisnumber" />
            <x-input-error class="mt-2" :messages="$errors->get('housenumber')" />
        </div>

        <div>
            <x-input-label for="postcode" :value="__('Postcode')" />
            <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode', $user['postcode'])" required autofocus autocomplete="postcode" />
            <x-input-error class="mt-2" :messages="$errors->get('postcode')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user['city'])" required autofocus autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="dateOfBirth" :value="__('Date of Birth')" />
            <x-text-input id="dateOfBirth" name="dateOfBirth" class="mt-1 block w-full" :value="old('dateOfBirth', $user['dateOfBirth'])" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('dateOfBirth')" />
        </div>

        <div>
            <x-input-label for="bankaccountnumber" :value="__('Bankaccountnumber')" />
            <x-text-input id="bankaccountnumber" name="bankaccountnumber" type="text" class="mt-1 block w-full" :value="old('bankaccountnumber', $user['bankaccountnumber'])" required autofocus autocomplete="bankaccountnumber" />
            <x-input-error class="mt-2" :messages="$errors->get('bankaccountnumber')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user['email'] ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>





            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
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

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
