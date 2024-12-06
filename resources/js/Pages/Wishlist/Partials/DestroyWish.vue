<script setup>
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
  wish: {
    type: Object,
    required: true
  }
});

const user = usePage().props.auth.user;

const handleClick = () => {
  axios.delete(`/users/${user.id}/wishlist/${props.wish.id}`)
    .then(response => {
      router.reload({ only: ["wishlist"], preserveState: true });
    })
    .catch(error => {
      console.error(error);
    });
};
</script>

<template>
    <button
      @click="handleClick"
      :class="[
        'icon-button delete'
      ]"
    >
      <i aria-hidden="true"></i>
    </button>
</template>
