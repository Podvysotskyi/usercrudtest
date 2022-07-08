<template>

    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:px-6 lg:px-8 bg-white border-b border-gray-200">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900">
                                    Users
                                </h1>
                                <p class="mt-2 text-sm text-gray-700">
                                    A list of all the users.
                                </p>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <Button :href="route('create-user')"
                                    class="bg-indigo-600 hover:bg-indigo-700 focus:border-indigo-500">
                                    Add User
                                </Button>
                            </div>
                        </div>

                        <div
                            class="-mx-4 mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
                            <Table :data="users.data" :meta="users.meta" :links="users.links">
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                    ID
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Name
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Email
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                    <span class="sr-only">Edit</span>
                                </th>

                                <template #row="{ row }">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        {{ row.id }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ row.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ row.email }}
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                        <span class="text-red-600 hover:text-red-900 hover:text-red-900 cursor-pointer"
                                            @click="openModal(row)" v-if="row.id !== $page.props.auth.user.id">
                                            Delete<span class="sr-only">, {{ row.id }}</span>
                                        </span>
                                        <Link :href="route('edit-user', row.id)"
                                            class="ml-3 text-indigo-600 hover:text-indigo-900">
                                        Edit<span class="sr-only">, {{ row.id }}</span>
                                        </Link>
                                    </td>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <TransitionRoot as="template" :show="open">
            <Dialog as="div" class="relative z-10" @close="closeModal()">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel
                                class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                            Delete user
                                        </DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to delete user?
                                                All of user data will be permanently removed from our servers forever.
                                                This action cannot be undone.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                    <button type="button" @click="deleteUser()"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                        Delete
                                    </button>
                                    <button type="button" @click="closeModal()" ref="cancelButtonRef"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { ExclamationIcon } from '@heroicons/vue/outline';

import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Table from '@/Components/Table.vue';
import Button from '@/Components/Button.vue';

export default {
    props: {
        users: Object,
    },
    components: {
        Head, Link,
        Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,
        ExclamationIcon,
        AuthenticatedLayout, Table, Button,
    },
    data: () => ({
        open: false,
        user: 0,
    }),
    methods: {
        openModal(user) {
            if (this.open) return

            this.user = user.id
            this.open = true
        },
        closeModal() {
            if (!this.open) return

            this.user = 0
            this.open = false
        },
        deleteUser() {
            if (!this.open || !this.user) return this.closeModal()

            this.$inertia.delete(route('destroy-user', this.user), {
                onFinish: () => this.closeModal()
            })
        },
    },
}
</script>
