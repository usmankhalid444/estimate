<template>
    <Head title="Add Client" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Client
            </h2>
        </template>
        <form @submit.prevent="submit">
            <div
                class="grid grid-cols-12 w-5/12 mx-auto gap-x-10 gap-y-8 mt-12"
            >
                <div class="col-span-6">
                    <span>First Name:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="client.first_name"
                    />
                </div>
                <div class="col-span-6">
                    <span>Last Name:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="client.last_name"
                    />
                </div>
                <div class="col-span-6">
                    <span>Phone:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="client.phone"
                    />
                </div>
                <div class="col-span-6">
                    <span>Email:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="client.email"
                    />
                </div>
                <div class="col-span-6">
                    <span>Address:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="client.address"
                    />
                </div>
                <div class="col-span-12">
                    <button
                        type="submit"
                        :disabled="!enableSubmit"
                        class="bg-blue-600 text-white w-full py-2"
                    >
                        Add Client
                    </button>
                </div>
            </div>
        </form>
        <p class="text-center mt-10 text-2xl">{{ message }}</p>
    </BreezeAuthenticatedLayout>
</template>
<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";
import axios from "axios";
const client = reactive({
    first_name: null,
    last_name: null,
    phone: null,
    email: null,
    address: null,
});
const message = ref();
const enableSubmit = ref(true);

function submit() {
    enableSubmit.value = false;

    axios
        .post("customers", client)
        .then(() => {
            enableSubmit.value = true;

            message.value = "data edded successfully";
            client.first_name = "";
            client.last_name = "";
            client.phone = "";
            client.email = "";
            client.address = "";
        })
        .catch((err) => {
            message.value = err;
            enableSubmit.value = true;
        });
}
</script>
