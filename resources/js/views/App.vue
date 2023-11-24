<template>
  <div class="min-h-screen bg-white dark:bg-slate-800">
    <div id="top_border" />
    <OctoCat
      v-if="showOctoCat"
      repo="jeremykenedy/laravel-spa"
      position="right-top"
      animated-eye
      animated-ear
      animated-arm
      show-face
      :dark-mode="darkMode"
    />
    <VerifyNotice
      v-if="
        $route.name !== 'home' &&
        $route.name !== 'verify-email' &&
        authenticated &&
        user &&
        user.id &&
        !user.email_verified_at &&
        !isAdminPage
      "
      :id="user.id"
    />

    <div class="w-full">
      <router-view v-slot="{ Component }" :class="isAdminPage ? '' : ''">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </div>
    <AppFooter v-if="!isAdminPage" class="sticky top-[100vh] w-full" />
    <AppToast />
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import AppFooter from '@components/AppFooter.vue';
import NavBar from '@/components/NavBar.vue';
import VerifyNotice from '@components/VerifyNotice.vue';
import OctoCat from '@components/OctoCat.vue';
import Sidebar from '@/components/Sidebar.vue';
import { ref } from 'vue';

export default {
  components: {
    // Sidebar,
    VerifyNotice,
    // AppFooter,
    OctoCat,
    // NavBar,
  },
  setup() {
    const sidebarOpen = ref(false);
    return {
      sidebarOpen,
    };
  },
  computed: {
    ...mapGetters({
      darkMode: 'auth/darkMode',
    }),
    currentRouteName() {
      return this.$route.name;
    },
    isAdminPage() {
      if (
        this.currentRouteName == 'admin' ||
        this.currentRouteName == 'roles' ||
        this.currentRouteName == 'permissions' ||
        this.currentRouteName == 'settings' ||
        this.currentRouteName == 'users' ||
        this.currentRouteName == 'app-settings' ||
        this.currentRouteName == 'phpinfo' ||
        this.currentRouteName == 'dashboard'
      ) {
        return true;
      }
      return false;
    },
    showOctoCat() {
      if (
        this.currentRouteName == 'home' ||
        this.currentRouteName == 'about' ||
        this.currentRouteName == 'terms'
      ) {
        return true;
      }
      return false;
    },
  },
  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
