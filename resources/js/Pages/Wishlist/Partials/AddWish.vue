<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const form = useForm({
    wish: '',
});

const submit = (e) => {
  e.preventDefault();
  form.post(route('wishlist.add', { userId: user.id }), {
    onFinish: () => {
      form.wish = '';
      router.reload({ only: ["wishlist"], preserveState: true });
      scrollToBottom();
    }
  });
};

const scrollToBottom = () => {
  // This will scroll to the bottom of the page
  window.scrollTo({
    top: document.documentElement.scrollHeight,
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <table class="min-w-full divide-y divide-gray-200 table-fixed">
      <tr class="border-gray-200 border-t-2">
        <td class="flex flex-col gap-5 py-4 px-6 whitespace-nowrap">
          <div class="flex">
            <TextInput
              id="wish"
              type="text"
              class="block w-full"
              v-model="form.wish"
              required
              autofocus
            />
            
            <InputError class="mt-2" :message="form.errors.wish" />
          </div>
          <div class="flex justify-end self-center">
            <button class="secret-santa-button"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Add Wish
            </button>
          </div>
        </td>
      </tr>
    </table>
  </form>
</template>
