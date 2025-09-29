<x-guest-layout>
    <form x-data="feedbackForm()" x-on:submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" x-model="form.name"
                autofocus required />
            <template x-for="msg in errors.name" :key="msg">
                <p class="text-red-600 text-xs mt-2" x-text="msg"></p>
            </template>
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" data-mask="phone"
                x-model="form.phone" required />
            <template x-for="msg in errors.phone" :key="msg">
                <p class="text-red-600 text-xs mt-2" x-text="msg"></p>
            </template>
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" x-model="form.email"
                required />
            <template x-for="msg in errors.email" :key="msg">
                <p class="text-red-600 text-xs mt-2" x-text="msg"></p>
            </template>
        </div>

        <!-- Subject -->
        <div>
            <x-input-label for="subject" :value="__('Subject')" />
            <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" x-model="form.subject"
                required />
            <template x-for="msg in errors.subject" :key="msg">
                <p class="text-red-600 text-xs mt-2" x-text="msg"></p>
            </template>
        </div>

        <!-- Body -->
        <div>
            <x-input-label for="body" :value="__('Body')" />
            <x-textarea id="body" class="block mt-1 w-full" name="body" rows="4" x-model="form.body"
                required />
            <template x-for="msg in errors.body" :key="msg">
                <p class="text-red-600 text-xs mt-2" x-text="msg"></p>
            </template>
        </div>

        <!-- File -->
        <div>
            <x-input-label for="files" :value="__('Files')" />
            <input id="files" type="file" name="files[]" class="block mt-1 w-full" x-ref="files" multiple>
            <template x-for="(msgs, key) in errors" :key="key">
                <template x-if="key.startsWith('files.')">
                    <p class="text-red-600 text-xs mt-2" x-text="msgs[0]"></p>
                </template>
            </template>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button type="submit" class="ms-3" x-bind:disabled="loading">
                <span x-show="!loading">{{ __('Send') }}</span>
                <span x-show="loading">{{ __('Sending...') }}</span>
            </x-primary-button>
        </div>

        <div class="mt-2">
            <p class="text-green-600 text-xs" x-text="successMessage"></p>
            <p class="text-red-600 text-xs" x-text="errorMessage"></p>
        </div>
    </form>

    <script>
        function feedbackForm() {
            return {
                form: {
                    name: '',
                    phone: '',
                    email: '',
                    subject: '',
                    body: ''
                },
                errors: {},
                successMessage: '',
                errorMessage: '',
                loading: false,

                async submit() {
                    this.loading = true;
                    this.errors = {};
                    this.successMessage = '';
                    this.errorMessage = '';

                    const formData = new FormData();
                    for (let key in this.form) {
                        formData.append(key, this.form[key]);
                    }

                    if (this.$refs.files && this.$refs.files.files.length > 0) {
                        Array.from(this.$refs.files.files).forEach((file, i) => {
                            formData.append('files[]', file);
                        });
                    }

                    try {
                        const response = await fetch("{{ url('/api/tickets') }}", {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.errors = data.errors || {};
                        } else {
                            this.successMessage = data.message;
                            this.form = {
                                name: '',
                                phone: '',
                                email: '',
                                subject: '',
                                body: ''
                            };
                            this.$refs.files.value = '';
                        }
                    } catch (e) {
                        this.errorMessage = 'Network error';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-guest-layout>
