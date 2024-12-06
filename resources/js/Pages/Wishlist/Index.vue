<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddWish from '@/Pages/Wishlist/Partials/AddWish.vue';
import DestroyWish from '@/Pages/Wishlist/Partials/DestroyWish.vue';
import UpdateWishButton from '@/Pages/Wishlist/Partials/UpdateWishButton.vue';
import UpdateWish from '@/Pages/Wishlist/Partials/UpdateWish.vue';
import Wishlist from '@/Pages/Wishlist/Partials/Wishlist.vue'
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  wishlist: {
    type: Array,
  },
  userId: {
    type: Number,
  },
  userName: {
    type: String,
  }
});


const update = ref(false);
const updateIndex = ref(0);
const userId = props.userId;
const userName = props.userName;
const updateClicked = (value, index) => {
  update.value = value;
  updateIndex.value = index;
}

const user = usePage().props.auth.user;

const isUsersWishlist = () => {
  return (userId == user.id);
}

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{userName}}'s Wishlist</h2>
    </template>
    <Wishlist :wishlist="wishlist" :userId="userId" :userName="userName"/>
  </AuthenticatedLayout>
</template>