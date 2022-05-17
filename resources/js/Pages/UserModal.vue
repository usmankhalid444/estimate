<template>
    <vue-final-modal
        name="UserDetailModal"
        v-slot="{ close }"
        v-bind="$attrs"
        classes="flex justify-center items-center overflow-scroll"
        content-class="w-full md:w-3/4 xl:w-4/12 relative max-h-full mx-4 md:p-12 p-5 border rounded bg-white"
    >
        <div @click="close" class="text-2xl float-right cursor-pointer">X</div>
        <div class="text-2xl space-y-5">
            <p class="text-center text-3xl mb-8">Client Information</p>
            <p>
                First Name:
                <span class="text-green-700 ml-5">{{
                    customer.first_name
                }}</span>
            </p>
            <p>
                Last Name:
                <span class="text-green-700 ml-5">{{
                    customer.last_name
                }}</span>
            </p>
            <p>
                Contact No:
                <span class="text-green-700 ml-5">{{ customer.phone }}</span>
            </p>
            <p>
                Email:
                <span class="text-green-700 ml-5">{{ customer.email }}</span>
            </p>
            <p>
                Address:
                <span class="text-green-700 ml-5">{{ customer.address }}</span>
            </p>
        </div>
    </vue-final-modal>
</template>
<script setup>
import { VueFinalModal } from "vue-final-modal";
import { defineProps, defineEmits, defineComponent } from "vue";
const props = defineProps(["customer"]);
defineComponent({
    inheritAttrs: false,
});
const emit = defineEmits(["cancel", "confirm"]);
</script>
