<script setup>
import { ref, onMounted, watch } from 'vue';
import confetti from 'canvas-confetti';  // Import confetti library
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Array,
    },
    secretSanta: {
      type: Object,
    },
    reveal: {
      type: Boolean,
      required: true,
    },
    firstTime: {
      type: Boolean,
      required: true,
    }
});

const emit = defineEmits(['show']);

const currentUser = ref(null);
const cycleCount = ref(0);
const isSecretSantaVisible = props.firstTime ? ref(false) : ref(true);

const triggerConfetti = () => {
    // The element you want to center the confetti around
    const targetElement = document.querySelector('.confetti-element'); // Change this selector to match your target element

    if (!targetElement || props.secretSanta == undefined) return;

    // Get the element's position and size
    const rect = targetElement.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;

    const numberOfConfettiBursts = 12; // Number of bursts around the circle (you can increase this number)
    const radius = 100; // Radius of the circle (how far the confetti will be from the center)

    // Loop to create confetti bursts around the target element
    for (let i = 0; i < numberOfConfettiBursts; i++) {
        // Calculate the angle for each burst
        const angle = (i / numberOfConfettiBursts) * 2 * Math.PI;

        // Calculate the x, y coordinates for each burst around the circle
        const x = centerX + radius * Math.cos(angle);
        const y = centerY + radius * Math.sin(angle);

        // Trigger confetti at this position
        confetti({
            particleCount: 100, // Number of particles in each burst
            spread: 360,        // Spread in degrees
            origin: { x: x / window.innerWidth, y: y / window.innerHeight }, // Normalized coordinates
            startVelocity: 50,  // Starting velocity (optional, adjust to your liking)
        });
    }
};

const setSecretSanta = () => {
  axios.put(`/dashboard/${props.secretSanta.id}`)
    .then(response => {
      isSecretSantaVisible.value = true;
      triggerConfetti();
      emit('show');
    })
    .catch(error => {
      console.error(error);
    });
};

const getRandomUser = () => {
    return props.users[Math.floor(Math.random() * props.users.length)];
};

const startSecretSantaCycle = () => {
    const interval = setInterval(() => {
        currentUser.value = getRandomUser();
        cycleCount.value++;

        if (cycleCount.value === 20) {
            clearInterval(interval);
            setSecretSanta();
        }
    }, 100);
};

watch(
  () => props.reveal, 
  (newReveal) => {
    if(cycleCount.value >= 20) {
      triggerConfetti();
    }
    if(props.firstTime) {
      startSecretSantaCycle();
    }
    else {
      triggerConfetti();
    }
  }
);

watch(
  () => isSecretSantaVisible, 
  (visible) => {
    triggerConfetti();
  }
);
</script>

<template>
  <div class="flex justify-center items-center bg-gray-100">
    <div class="text-center space-y-4">
      <div v-if="!isSecretSantaVisible" class="text-4xl font-bold text-blue-600 animate-pulse">
        <p class="mt-4 text-6xl">{{ currentUser ? currentUser.name : '' }}</p>
      </div>
      <div class="confetti-element"></div>
      <div v-if="isSecretSantaVisible && secretSanta != undefined" class=" text-4xl font-bold text-green-500">
        <p class="text-2xl mb-2">Your Secret Santa is...</p>
        <p class="text-6xl">{{ secretSanta ? secretSanta.name : ''}}</p>
      </div>
    </div>
  </div>
</template>
