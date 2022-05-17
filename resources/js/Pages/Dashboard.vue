<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estimate
            </h2>
        </template>
        <form @submit.prevent="saveEstimate">
            <div class="grid grid-cols-12 w-11/12 mx-auto">
                <div class="col-span-4 mt-12">
                    <p class="text-3xl mt-10">
                        Project Name:
                        <span class="text-green-700">{{
                            estimate.project_name
                        }}</span>
                    </p>
                    <p class="text-3xl mt-10">
                        Project Type:
                        <span class="text-green-700">{{
                            estimate.project_type
                        }}</span>
                    </p>
                    <p class="text-3xl mt-10">
                        Client Name:
                        <span class="text-green-700">{{ customerName() }}</span>
                    </p>
                    <p class="text-3xl mt-10">
                        Estimated Cost:
                        <span v-if="getEstimate()[0] > 0" class="text-green-700"
                            >{{ getEstimate()[0] }} $
                        </span>
                    </p>
                    <p class="text-3xl mt-10">
                        Estimated Time:
                        <span v-if="getEstimate()[1] > 0" class="text-green-700"
                            >{{ getEstimate()[1] }} Days</span
                        >
                    </p>
                    <button
                        type="submit"
                        :disabled="!enableSubmit"
                        class="text-3xl bg-green-700 hover:bg-green-600 text-white px-5 py-1 rounded-md mt-9"
                    >
                        Save
                    </button>
                    <p class="text-3xl text-green-700 mt-10">
                        {{ msg }}
                    </p>
                </div>
                <div class="col-span-8 mt-12 w-10/12 mx-auto">
                    <p>Project Name:</p>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="estimate.project_name"
                    />
                    <p class="mt-5">Project Type:</p>
                    <input
                        class="w-full"
                        type="text"
                        required
                        v-model="estimate.project_type"
                    />
                    <p class="mt-5">Client Name:</p>
                    <select class="w-full" v-model="customer" required>
                        <option value="" selected disabled hidden>
                            Choose here
                        </option>
                        <option
                            v-for="(client, i) in clients"
                            :key="i"
                            :value="client"
                        >
                            {{ client.first_name }} {{ client.last_name }}
                        </option>
                    </select>
                    <p class="mt-5">Features:</p>
                    <div
                        class="grid grid-cols-2 w-full bg-white border border-gray-400 gap-5 p-2"
                    >
                        <label
                            class="flex items-center cursor-pointer float-right border-b"
                            v-for="(feature, i) in features"
                            :key="i"
                        >
                            <span class="underline decoration-blue-700 mr-3">{{
                                feature.name
                            }}</span>
                            <div class="relative">
                                <input
                                    v-model="selected_feature"
                                    class="sr-only"
                                    :value="feature"
                                    type="checkbox"
                                />
                                <!-- line -->
                                <div
                                    class="block bg-gray-300 border border-gray-300 w-8 h-5 rounded-full bg"
                                ></div>
                                <!-- dot -->
                                <div
                                    class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"
                                ></div>
                            </div>
                        </label>
                    </div>
                    <p class="mt-5">
                        Additional Cost:
                        <span class="text-gray-600 px-4">($)</span>
                    </p>
                    <input
                        class="w-full"
                        type="number"
                        v-model="additional_cost"
                    />
                    <p class="mt-5">
                        Additional Time:
                        <span class="text-gray-600 px-4">(days)</span>
                    </p>
                    <input
                        class="w-full mb-10"
                        type="number"
                        v-model="additional_time"
                    />
                </div>
            </div>
        </form>
    </BreezeAuthenticatedLayout>
</template>
<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { ref, defineProps } from "vue";
import axios from "axios";
import { debounce } from "lodash";

const props = defineProps({
    features: Array,
    clients: Array,
});
const estimate = ref({
    project_name: "",
    project_type: "",
    estimated_cost: null,
    estimated_time: null,
    customer_name: "",
    customer_id: 0,
    selected_feature_id: [],
});
const selected_feature = ref([]);
const additional_cost = ref(null);
const additional_time = ref(null);
const msg = ref("press save");
const enableSubmit = ref(true);
const customer = ref("");
let customerName = () => {
    estimate.value.customer_id = customer.value.id;
    if (customer.value.first_name) {
        estimate.value.customer_name =
            customer.value.first_name + " " + customer.value.last_name;
    } else {
        return "";
    }

    return estimate.value.customer_name;
};
const getEstimate = () => {
    // let estimated_cost = additional_cost.value;
    // let estimated_time = additional_time.value;
    let estimated_cost = null;
    let estimated_time = null;
    let feature = selected_feature.value;
    feature.map((f) => {
        estimated_cost += f.estimated_cost;
        estimated_time += f.estimated_time;
    });
    estimate.value.estimated_cost = estimated_cost + additional_cost.value;
    estimate.value.estimated_time = estimated_time + additional_time.value;
    return [
        estimated_cost + additional_cost.value,
        estimated_time + additional_time.value,
    ];
};
const saveEstimate = () => {
    enableSubmit.value = false;
    selected_feature.value.map((i) => {
        estimate.value.selected_feature_id.push(i.id);
    });

    axios
        .post("/save-estimate", estimate.value)
        .then(() => {
            enableSubmit.value = true;
            msg.value = "data saved";
            // reseting fields
            estimate.value.selected_feature_id = [];
            estimate.value.project_name = "";
            estimate.value.project_type = "";
            estimate.value.customer_name = "";
            (additional_cost.value = ""),
                (additional_time.value = ""),
                (estimate.value.estimated_cost = null);
            estimate.value.estimated_time = null;
            selected_feature.value = [];
        })
        .catch((err) => {
            msg.value = err;
            enableSubmit.value = true;
        });
};
</script>
<style scoped>
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: white;
}
input:checked ~ .bg {
    background-color: green;
    border: 1px solid green;
}
</style>
