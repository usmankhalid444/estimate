<template>
    <Head title="Add Feature" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Feature
            </h2>
        </template>
        <form @submit.prevent="submit">
            <div
                class="grid grid-cols-12 w-5/12 mx-auto gap-x-10 gap-y-8 mt-12"
            >
                <div class="col-span-6">
                    <span>Feature Name:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="feature.name"
                    />
                </div>
                <div class="col-span-6">
                    <span>Feature Description:</span>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="feature.description"
                    />
                </div>
                <div class="col-span-6">
                    <span>Estimated Time:</span>
                    <span class="text-gray-600 px-4">(hours)</span>
                    <input
                        class="w-full"
                        type="number"
                        required
                        v-model="feature.estimated_time"
                    />
                </div>
                <div class="col-span-6">
                    <span>Estimated Cost:</span>
                    <span class="text-gray-600 px-4">($)</span>
                    <input
                        class="w-full"
                        type="number"
                        required
                        v-model="feature.estimated_cost"
                    />
                </div>

                <div class="col-span-12">
                    <button
                        :disabled="!enableSubmit"
                        type="submit"
                        class="bg-blue-600 text-white w-full py-2"
                    >
                        Add Feature
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
const feature = reactive({
    name: null,
    description: null,
    estimated_time: null,
    estimated_cost: null,
});
const message = ref();
const enableSubmit = ref(true);
function submit() {
    enableSubmit.value = false;
    axios
        .post("features", feature)
        .then(() => {
            enableSubmit.value = true;
            message.value = "data edded successfully";
            feature.name = "";
            feature.description = "";
            feature.estimated_time = "";
            feature.estimated_cost = "";
        })
        .catch((err) => {
            message.value = err;
            enableSubmit.value = true;
        });
}
</script>
