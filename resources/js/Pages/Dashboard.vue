<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecretSantaReveal from '@/Components/SecretSantaReveal.vue';
import { ref } from 'vue';
import Wishlist from '@/Pages/Wishlist/Partials/Wishlist.vue'

const props = defineProps({
  users: {
    type: Object,
  },
  secretSanta: {
    type: Object,
  },
  firstTime: {
    type: Boolean,
  },
  wishlist: {
    type: Object,
  }
});

const reveal = ref(false);
const show = props.firstTime ? ref(false) : ref(true);

const showWishlist = () => {
  show.value = true;
}

const revealClick = () => {
  reveal.value = !reveal.value;
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Who Do I Have For Secret Santa?
            </h2>
        </template>

        <div class="who-i-have p-6 text-gray-900">
            <div class="explain">Welcome to the Schmidt's secret santa 2024!<br>Once everyone creates an account, press the button to find out who you have!</div>
            <button @click="revealClick" class="secret-santa-button">Who Do I have this year?!</button>
        </div>

        <SecretSantaReveal @show="showWishlist" :firstTime="firstTime" :reveal="reveal" :users="users" :secretSanta="secretSanta"/>
        <Wishlist v-if="show && secretSanta != undefined" :wishlist="wishlist" :userName="secretSanta ? secretSanta.name : ''"/>
    </AuthenticatedLayout>
</template>
