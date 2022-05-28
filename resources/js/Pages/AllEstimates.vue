<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Estimates
            </h2>
        </template>
        <div class="w-10/12 mx-auto">
            <div class="pb-20 grid grid-cols-3 gap-5 w-11/12 mx-auto">
                <div
                    class="mt-10 space-y-5 bg-slate-200 shadow-md hover:shadow-xl p-4"
                    v-for="(estimate, i) in estimates"
                    :key="i"
                >
                    <div>{{ getFeatures(estimate.features_ids) }}</div>
                    <p>
                        Project Name:
                        <span class="text-green-700 font-bold">{{
                            estimate.project_name
                        }}</span>
                    </p>
                    <p>
                        Project Type:
                        <span class="text-green-700 font-bold">{{
                            estimate.project_type
                        }}</span>
                    </p>
                    <p>
                        Customer Name:
                        <span
                            @click="showModal(estimate.customer)"
                            class="underline decoration-blue-500 cursor-pointer text-green-700 font-bold"
                            >{{ estimate.customer_name }}</span
                        >
                    </p>
                    <p>
                        Estimated Time:
                        <span class="text-green-700 font-bold">{{
                            estimate.estimated_time
                        }}</span>
                    </p>
                    <p>
                        Estimated Cost:
                        <span class="text-green-700 font-bold">{{
                            estimate.estimated_cost
                        }}</span>
                    </p>
                </div>
            </div>
        </div>
        <ModalsContainer />
    </BreezeAuthenticatedLayout>
    <div v-for="(item, index) in estimates" :key="index">
        {{ item }}
    </div>
</template>
<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { $vfm, ModalsContainer } from "vue-final-modal";
import UserModal from "./UserModal.vue";
import { ref } from "vue";
const features = ref();
const props = defineProps(["estimates", "features"]);
let showModal = (data) => {
    $vfm.show({
        component: UserModal,
        bind: {
            customer: data,
        },
    });
};
// console.log(props.estimates);
// console.log(props.features);
let getFeatures = (data) => {
    return "sdf";
};
</script>
