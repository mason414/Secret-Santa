<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import WishListButton from '@/Pages/Users/Partials/WishListButton.vue';

// Used to access Users Object from UsersController
defineProps({
  users: {
    type: Object,
  }
});

</script>

<template>
  <Head title="Users Index" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Participants</h2>
    </template>

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
                        <th scope="col" class="w-9/10 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('name')">
                            Name
                          </span>
                        </th>
                        <th scope="col" style="width: 10%;" class="text-xs font-semibold tracking-wider text-center text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between">
                            Actions
                          </span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <!-- Start looping the Users Object -->
                      <tr v-for="(user, index) in users" :key="user.id" class="table-row">
                        <td class="py-4 px-6 whitespace-nowrap">
                          <span>{{ user.name }}</span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                          <WishListButton :href="route('wishlist.index', { userId: user.id })">
                            See Wishlist <i class='fas fa-arrow-right'></i>
                          </WishListButton>
                        </td>
                      </tr>
                      <!-- End looping the Users Object -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>