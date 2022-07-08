<template>
    <GuestLayout>

        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="password" value="Password" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <Button class="ml-4 bg-gray-600 hover:bg-gray-700 focus:border-gray-500" :disabled="form.processing">
                    Confirm
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

<script>
import { Head, useForm } from '@inertiajs/inertia-vue3';

import Button from '@/Components/Button.vue';
import GuestLayout from '@/Layouts/Guest.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';

export default {
    components: {
        Head,
        Button, GuestLayout, Input, Label, ValidationErrors
    },
    data: () => ({
        form: useForm({
            password: '',
        }),
    }),
    methods: {
        submit() {
            this.form.post(route('password.confirm'), {
                onFinish: () => this.form.reset(),
            })
        }
    },
}
</script>