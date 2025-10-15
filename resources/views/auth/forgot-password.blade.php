<x-guest-layout>
    <section class="min-h-[60vh] flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-4">
        <div class="w-full max-w-md">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6 sm:p-8">
                <div class="mb-6 text-center space-y-1">
                    <img
                        src="{{ asset('images/avatar-default.svg') }}"
                        alt="Avatar"
                        loading="lazy"
                        class="mx-auto h-14 w-14 rounded-full ring-1 ring-gray-200 shadow-sm"
                    />
                    <h1 class="text-2xl font-semibold text-gray-900">Mot de passe oublié</h1>
                    <p class="text-sm text-gray-600">
                        Saisissez votre adresse e‑mail pour recevoir un lien de réinitialisation.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input
                            id="email"
                            class="mt-1 block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            placeholder="vous@exemple.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                            Retour à la connexion
                        </a>
                        <x-primary-button class="inline-flex items-center justify-center transition-all duration-200 hover:shadow-md focus:ring-4 focus:ring-indigo-300">
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
