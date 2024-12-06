<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';

const emit = defineEmits(['update-clicked']);

const props = defineProps({
  wish: {
    type: Object,
    required: true
  }
});

const user = usePage().props.auth.user;

const form = useForm({
    wish: props.wish.wish,
});

const cancelClick = () => {
  emit('update-clicked', false);
}

const submit = (e) => {
  e.preventDefault();
  form.put(route('wishlist.update', { userId: user.id, wishId: props.wish.id }), {
    onFinish: () => {
      emit('update-clicked', false);
      router.reload({ only: ["wishlist"], preserveState: true });
    }
  });
};

</script>

<template>
  <form @submit.prevent="submit">
    <div>
      <TextInput
        :id="wish.id"
        type="text"
        class="mt-1 block w-full"
        v-model="form.wish"
        required
        autofocus
      />
      
      <InputError class="mt-2" :message="form.errors.wish" />
    </div>
    <div class="mt-4 flex justify-start self-center">
      <button class="secret-santa-button small"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Update Wish
      </button>
      <button class="secret-santa-button small ms-4"
        @click="cancelClick"
        >
        Cancel Update
      </button>
    </div>
  </form>
</template>