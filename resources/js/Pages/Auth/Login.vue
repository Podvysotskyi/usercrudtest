<template>
    <GuestLayout>

        <Head title="Log in" />

        <ValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Label for="email" value="Email" />
                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <Label for="password" value="Password" />
                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900">
                Forgot your password?
                </Link>

                <Button class="ml-4 bg-gray-600 hover:bg-gray-700 focus:border-gray-500"
                    :disabled="form.processing">
                    Log in
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

import Button from '@/Components/Button.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/Guest.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';

export default {
    props: {
        canResetPassword: Boolean,
        status: String,
    },
    components: {
        Head, Link,
        Button, Checkbox, GuestLayout, Input, Label, ValidationErrors
    },
    data: () => ({
        form: useForm({
            email: '',
            password: '',
            remember: false
        }),
    }),
    methods: {
        submit() {
            this.form.post(route('login'), {
                onFinish: () => this.form.reset('password'),
            });
        }
    },
}
</script>