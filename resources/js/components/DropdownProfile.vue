<template>
  <div class="relative inline-flex">
    <button
      ref="trigger"
      class="inline-flex justify-center items-center group"
      aria-haspopup="true"
      :aria-expanded="dropdownOpen"
      @click.prevent="dropdownOpen = !dropdownOpen"
    >
      <img
        class="w-8 h-8 rounded-full"
        :src="UserAvatar"
        width="32"
        height="32"
        alt="User"
      />
      <div class="flex items-center truncate">
        <span
          class="truncate ml-2 text-sm font-medium group-hover:text-slate-800"
          >Acme Inc.</span
        >
        <svg
          class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
          viewBox="0 0 12 12"
        >
          <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
        </svg>
      </div>
    </button>
    <transition
      enter-active-class="transition ease-out duration-200 transform"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-out duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-show="dropdownOpen"
        class="origin-top-right z-10 absolute top-full min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
        :class="align === 'right' ? 'right-0' : 'left-0'"
      >
        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
          <div class="font-medium text-slate-800">
            {{ user && user.name ? user.name : 'Registered User' }}!
          </div>
          <div class="text-xs text-slate-500 italic">
            <RolesBadges :roles="roles" />
          </div>
        </div>
        <ul
          ref="dropdown"
          @focusin="dropdownOpen = true"
          @focusout="dropdownOpen = false"
        >
          <li>
            <!--            <router-link-->
            <!--              class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"-->
            <!--              to="/profile/settings"-->
            <!--              @click="dropdownOpen = false"-->
            <!--              >Settings</router-link-->
            <!--            >-->

            <router-link
              :to="{ name: 'profile-settings' }"
              class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
              @click="dropdownOpen = false"
            >
              Settings
            </router-link>
          </li>
          <li>
            <div
              class="flex cursor-pointer items-center rounded-b p-4 pr-10 pl-8 text-gray-700 hover:bg-slate-800 hover:text-white"
              @click.prevent="logout(), closeDrop()"
            >
              <!--              <ArrowLeftOnRectangleIcon-->
              <!--                class="mr-2 h-6 w-6"-->
              <!--              ></ArrowLeftOnRectangleIcon>-->
              Logout
            </div>
          </li>
        </ul>
      </div>
    </transition>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import UserAvatar from '../../img/auth/user-avatar-32.png';
import { mapActions, mapGetters, mapState } from 'vuex';
import { parseDisplayDate } from '@services/common';
import RolesBadges from '@/components/roles/RolesBadges.vue';

export default {
  name: 'DropdownProfile',
  components: { RolesBadges },
  props: ['align'],
  setup() {
    const dropdownOpen = ref(false);
    const trigger = ref(null);
    const dropdown = ref(null);

    // close on click outside
    const clickHandler = ({ target }) => {
      if (
        !dropdownOpen.value ||
        dropdown.value.contains(target) ||
        trigger.value.contains(target)
      )
        return;
      dropdownOpen.value = false;
    };

    // close if the esc key is pressed
    const keyHandler = ({ keyCode }) => {
      if (!dropdownOpen.value || keyCode !== 27) return;
      dropdownOpen.value = false;
    };

    onMounted(() => {
      document.addEventListener('click', clickHandler);
      document.addEventListener('keydown', keyHandler);
    });

    onUnmounted(() => {
      document.removeEventListener('click', clickHandler);
      document.removeEventListener('keydown', keyHandler);
    });

    return {
      dropdownOpen,
      trigger,
      dropdown,
    };
  },
  data() {
    return {
      UserAvatar: UserAvatar,
    };
  },
  computed: {
    ...mapState('auth', {
      user: (state) => state.user,
    }),
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
      logins: 'auth/logins',
    }),
  },
  methods: {
    ...mapActions({
      logout: 'auth/logout',
      updateTheme: 'auth/theme',
      popToast: 'toast/popToast',
      leaveImpersonatingUser: 'auth/leaveImpersonatingUser',
    }),
    parseDisplayDate,
    closeDrop() {
      this.drop = false;
    },
    openDrop() {
      this.drop = true;
    },
    async toggleTheme() {
      this.loading = true;
      this.errors = null;
      this.success = '';
      try {
        await this.updateTheme({ theme_dark: !this.user.theme_dark }).then(
          (response) => {
            if (
              response &&
              response.data &&
              response.data.user &&
              response.data.user.id
            ) {
              this.popToast({
                message: 'Theme Saved',
                timer: 2000,
                icon: 'success',
              });
            }
          },
        );
      } catch (e) {
        this.errors = e.data;
        this.popToast({
          message: 'Error Updating Theme',
          timer: 5000,
          icon: 'error',
        });
      }
      this.loading = false;
    },
    async leaveImpersonating() {
      try {
        await this.leaveImpersonatingUser().then((response) => {
          //
        });
      } catch (e) {
        this.popToast({
          message: 'Unable To Return To Yourself',
          timer: 5000,
          icon: 'error',
        });
      }
    },
  },
};
</script>
