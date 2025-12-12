<div class="flex min-h-screen w-full bg-cover bg-center"
    style="background-image: url('{{ url('images/login-bg.png') }}');">
    <!-- Left Side: Spacer (to keep form on right) -->
    <div class="hidden w-1/2 lg:block"></div>

    <!-- Right Side: Login Form (Transparent) -->
    <div class="flex w-full flex-col items-center justify-center p-8 lg:w-1/2 login-form-container backdrop-blur-sm">
        <div class="w-full max-w-md space-y-8">
            <div class="text-left">
                <h2 class="text-4xl font-bold text-gray-900">Selamat Datang</h2>
                <div class="mt-2 h-1.5 w-12 bg-black"></div>
            </div>

            <form wire:submit="authenticate" class="mt-10 space-y-6">
                {{ $this->form }}

                <div class="pt-4">
                    <button type="submit"
                        class="flex w-full justify-center rounded-full bg-black px-3 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black transition-colors duration-200">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
    <style>
        /* Force text colors in the login form */
        .login-form-container label,
        .login-form-container .fi-fo-field-wrp-label,
        .login-form-container .fi-fo-field-wrp-label span {
            color: #000 !important;
        }

        /* Style inputs to be flushed (bottom border only) */
        .login-form-container .fi-input-wrp {
            background-color: white !important;
            border-width: 0 0 1px 0 !important;
            border-radius: 12px !important;
            box-shadow: none !important;
            border-color: #000 !important;
            /* Black border for visibility */
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .login-form-container .fi-input-wrp:focus-within {
            border-color: #000 !important;
            ring: 0 !important;
        }

        .login-form-container input {
            color: #000 !important;
            padding-left: 0 !important;
        }

        /* Checkbox text */
        .login-form-container .fi-checkbox-input {
            color: #000 !important;
        }

        .login-form-container .fi-fo-field-wrp-label {
            color: #000 !important;
        }
    </style>
</div>