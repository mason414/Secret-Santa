<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Head title="Welcome" />
        <div
            id="background"
            class="welcome-page background"
        >

          <header class="header">
            <div class="header-message">Welcome to the Schmidt's secret santa!</div>
              <nav class="nav" v-if="canLogin">
                  <Link
                      v-if="$page.props.auth.user"
                      :href="route('dashboard')"
                      class="button"
                  >
                      Let's Go!
                  </Link>

                  <template v-else>
                      <Link
                          :href="route('login')"
                          class="secret-santa-button"
                      >
                          Log in
                      </Link>

                      <Link
                          v-if="canRegister"
                          :href="route('register')"
                          class="secret-santa-button"
                      >
                          Register
                      </Link>
                  </template>
              </nav>
          </header>
        </div>
</template>
