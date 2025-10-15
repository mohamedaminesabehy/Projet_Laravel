<x-guest-layout>
    <section class="min-h-[60vh] flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-4">
        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6 sm:p-8">
                <div class="mb-6 text-center space-y-1">
                    <h1 class="text-2xl font-semibold text-gray-900">Définir un nouveau mot de passe</h1>
                    <p class="text-sm text-gray-600">Votre mot de passe doit être confidentiel et sécurisé.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input
                            id="email"
                            class="mt-1 block w-full"
                            type="email"
                            name="email"
                            :value="old('email', $request->email)"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="vous@exemple.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input
                            id="password"
                            class="mt-1 block w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input
                            id="password_confirmation"
                            class="mt-1 block w-full"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                            Retour à la connexion
                        </a>
                        <x-primary-button class="inline-flex items-center justify-center transition-all duration-200 hover:shadow-md focus:ring-4 focus:ring-indigo-300">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
