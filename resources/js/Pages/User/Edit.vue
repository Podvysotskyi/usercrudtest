<template>

    <Head :title="`Edit User #${user.id}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User #{{ user.id }}
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <Label for="name" value="Name" />
                                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                    autofocus autocomplete="name" />
                                <p class="mt-2 text-sm text-red-500" v-if="form.errors.name">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <Label for="email" value="Email" />
                                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                                    autocomplete="username" />
                                <p class="mt-2 text-sm text-red-500" v-if="form.errors.email">
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <Label for="password" value="Password" />
                                <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                                    autocomplete="new-password" />
                                <p class="mt-2 text-sm text-red-500" v-if="form.errors.password">
                                    {{ form.errors.password }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <Label for="password_confirmation" value="Confirm Password" />
                                <Input id="password_confirmation" type="password" class="mt-1 block w-full"
                                    v-model="form.password_confirmation" autocomplete="new-password" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Button :disabled="form.processing"
                                    class="ml-4 bg-gray-600 hover:bg-gray-700 focus:border-gray-500">
                                    Save
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Head, useForm } from '@inertiajs/inertia-vue3';

import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import Button from '@/Components/Button.vue';

export default {
    props: {
        user: Object,
    },
    data: () => ({
        form: useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }),
    }),
    components: {
        Head,
        AuthenticatedLayout, Input, Label, Button,
    },
    created() {
        this.form.name = this.user.name
        this.form.email = this.user.email
    },
    methods: {
        submit() {
            this.form.post(`/users/${this.user.id}`, {
                onFinish: () => console.log(this.form.errors)
            })
        }
    },
}
</script>
