<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Reset password</h1>
                    </div>

                    <div class="mt-5">
                        <!-- Form -->
                        <form wire:submit.prevent="handleSubmit">
                            <!-- Display error message if present -->
                            @if (session('error'))
                                <div class="my-4 bg-red-500 text-sm text-white rounded-lg p-4" role="alert">
                                    <span class="font-bold">{{ session('error') }}</span>
                                </div>
                            @endif

                            <div class="grid gap-y-4">
                                <!-- Password Input -->
                                <div>
                                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                                    <input type="password" id="password" wire:model="password"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                    @error('password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Password Confirmation Input -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Confirm Password</label>
                                    <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                    @error('password_confirmation') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                    Save password
                                </button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
