<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddWish from '@/Pages/Wishlist/Partials/AddWish.vue';
import DestroyWish from '@/Pages/Wishlist/Partials/DestroyWish.vue';
import UpdateWishButton from '@/Pages/Wishlist/Partials/UpdateWishButton.vue';
import UpdateWish from '@/Pages/Wishlist/Partials/UpdateWish.vue';
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
const updateIndex = ref(-1);
const userId = props.userId;

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
  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-md sm:rounded-lg">
        <div class="flex flex-col">
          <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
              <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                  <thead class="bg-indigo-500">
                    <tr>
                      <th scope="col" class="w-10/10 text-xs font-semibold tracking-wider text-left text-white uppercase">
                        <span class="inline-flex py-3 px-6 w-full justify-between">
                          {{userName}}'s Wishlist
                        </span>
                      </th>
                      <th scope="col" style="width: 10%;" class="text-xs font-semibold tracking-wider text-center text-white uppercase" v-if="isUsersWishlist()">
                        <span class="py-3 px-6 w-full justify-between">
                          Actions
                        </span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr  v-if="wishlist.length <= 0 && !isUsersWishlist()">
                      <td class="py-4 px-6">{{userName}} hasn't put anything on their wishlist yet...</td>
                    </tr>
                    <tr v-for="(wish, index) in wishlist" :key="wish.id" class="table-row" :id="`row-${index}`">
                      <td class="py-4 px-6">
                        <span v-if="!update">
                          {{ wish.wish }}
                        </span>
                        <span v-else-if="index == updateIndex">
                          <UpdateWish :wish="wish" :index="index" @update-clicked="updateClicked"/>
                        </span>
                        <span v-else>
                          {{ wish.wish }}
                        </span>
                      </td>
                      <td class="py-4 px-6 whitespace-nowrap" v-if="isUsersWishlist() && index !== updateIndex">
                        <UpdateWishButton class="mr-2" @click="updateClicked(true, index)"/>
                        <DestroyWish :wish="wish"/>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <AddWish v-if="isUsersWishlist()"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>