<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- firstname -->
        <div>
            <x-input-label for="namejbk,bhk" :value="__('firstname')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="instertion" :value="__('instertion')" />
            <x-text-input id="instertion" class="block mt-1 w-full" type="text" name="instertion" :value="old('instertion')" autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('instertion')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="lastname" :value="__('Lastname')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

            <!-- phone -->
            <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="housenumber" :value="__('Housenumber')" />
            <x-text-input id="housenumber" class="block mt-1 w-full" type="text" name="housenumber" :value="old('housenumber')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('housenumber')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="postcode" :value="__('Zipcode')" />
            <x-text-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" :value="old('postcode')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="city" :value="__('city')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="dateofbirth" :value="__('Dateofbirth')" />
            <x-text-input id="dateofbirth" class="block mt-1 w-full" type="date" name="dateofbirth" :value="old('dateofbirth')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('dateofbirth')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="bankaccountnumber" :value="__('bankaccountnumber')" />
            <x-text-input id="bankaccountnumber" class="block mt-1 w-full" type="text" name="bankaccountnumber" required :value="old('bankaccountnumber')" autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('bankaccountnumber')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="instructor" :value="__('Instructor')" />
            <select name="instructor_id" id="" class="block mt-1 w-full">
                @foreach($instructors as $instructor)
                <option value="{{ $instructor->id }}">{{ $instructor->firstname . ' ' . $instructor->insertion . ' ' . $instructor->lastname }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('instructor_id')" class="mt-2" />
        </div>



        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="col-12 border rounded text-left px-2 pt-1">
            <span class="mb-3">Your password must require:</span>
            <ul>
                <li>15 characters in length</li>
                <li>1 capital letter</li>
                <li>1 number</li>
                <li>1 special character</li>
            </ul>
        </div> 

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button  class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        </div>
    </form>
    @if(session('message'))
        <div class="mt-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif
</x-guest-layout>
