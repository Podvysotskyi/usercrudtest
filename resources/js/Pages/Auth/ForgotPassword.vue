<template>
    <GuestLayout>

        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Button class="bg-gray-600 hover:bg-gray-700 focus:border-gray-500" :disabled="form.processing">
                    Email Password Reset Link
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
    props: {
        status: String,
    },
    components: {
        Head,
        Button, GuestLayout, Input, Label, ValidationErrors,
    },
    data: () => ({
        form: useForm({
            email: '',
        }),
    }),
    methods: {
        submit() {
            this.form.post(route('password.email'));
        }
    },
}
</script>