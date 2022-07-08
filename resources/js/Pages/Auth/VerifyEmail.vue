<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <Button class="bg-gray-600 hover:bg-gray-700 focus:border-gray-500" :disabled="form.processing">
                    Resend Verification Email
                </Button>

                <Link :href="route('logout')" method="post" as="button"
                    class="underline text-sm text-gray-600 hover:text-gray-900">Log Out</Link>
            </div>
        </form>
    </GuestLayout>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

import Button from '@/Components/Button.vue';
import GuestLayout from '@/Layouts/Guest.vue';

export default {
    props: {
        status: String,
    },
    components: {
        Head, Link,
        Button, GuestLayout,
    },
    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        },
    },
    data: () => ({
        form: useForm(),
    }),
    methods: {
        submit() {
            return this.form.post(route('verification.send'));
        },
    },
}
</script>