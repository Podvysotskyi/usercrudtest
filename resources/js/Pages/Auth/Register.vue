<template>
    <GuestLayout>

        <Head title="Register" />

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <Label for="name" value="Name" />
                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />
            </div>

            <div class="mt-4">
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <Label for="password" value="Password" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <Label for="password_confirmation" value="Confirm Password" />
                <Input id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
                </Link>

                <Button class="ml-4 bg-gray-600 hover:bg-gray-700 focus:border-gray-500" :disabled="form.processing">
                    Register
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

import Button from '@/Components/Button.vue';
import GuestLayout from '@/Layouts/Guest.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';

export default {
    components: {
        Head, Link,
        Button, GuestLayout, Input, Label, ValidationErrors,
    },
    data: () => ({
        form: useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms: false,
        }),
    }),
    methods: {
        submit() {
            this.form.post(route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            });
        },
    },
}
</script>