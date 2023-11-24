<template>
  <div class="flex h-screen overflow-hidden">
    <Sidebar :sidebar-open="sidebarOpen" @close-sidebar="sidebarOpen = false" />
    <div
      class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
    >
      <NavBar />
      <main>
        <div
          id="admin"
          class="bg-white p-3 dark:bg-slate-800 dark:text-gray-200"
        >
          <div v-if="roles" class="float-right mb-6 text-center">
            <RolesBadges :roles="roles" />
          </div>
          <nav class="mb-6 text-sm font-semibold" aria-label="Breadcrumb">
            <ol class="inline-flex list-none p-0">
              <li class="flex items-center">
                <router-link
                  v-if="
                    authenticated && roles && (roles.admin || roles.superAdmin)
                  "
                  v-slot="{ isActive }"
                  :to="{ name: 'admin' }"
                  class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
                >
                  <span
                    :class="[
                      isActive &&
                        'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
                    ]"
                  >
                    Admin
                  </span>
                </router-link>
              </li>
            </ol>
          </nav>
          <div
            class="relative bg-indigo-200 p-4 sm:p-6 rounded-sm overflow-hidden mb-8"
          >
            <div
              class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block"
              aria-hidden="true"
            >
              <svg
                width="319"
                height="198"
                xmlns:xlink="http://www.w3.org/1999/xlink"
              >
                <defs>
                  <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                  <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                  <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                  <linearGradient
                    id="welcome-b"
                    x1="50%"
                    y1="0%"
                    x2="50%"
                    y2="100%"
                  >
                    <stop stop-color="#A5B4FC" offset="0%" />
                    <stop stop-color="#818CF8" offset="100%" />
                  </linearGradient>
                  <linearGradient
                    id="welcome-c"
                    x1="50%"
                    y1="24.537%"
                    x2="50%"
                    y2="100%"
                  >
                    <stop stop-color="#4338CA" offset="0%" />
                    <stop stop-color="#6366F1" stop-opacity="0" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                  <g transform="rotate(64 36.592 105.604)">
                    <mask id="welcome-d" fill="#fff">
                      <use xlink:href="#welcome-a" />
                    </mask>
                    <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                    <path
                      fill="url(#welcome-c)"
                      mask="url(#welcome-d)"
                      d="M64-24h80v152H64z"
                    />
                  </g>
                  <g transform="rotate(-51 91.324 -105.372)">
                    <mask id="welcome-f" fill="#fff">
                      <use xlink:href="#welcome-e" />
                    </mask>
                    <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                    <path
                      fill="url(#welcome-c)"
                      mask="url(#welcome-f)"
                      d="M40.333-15.147h50v95h-50z"
                    />
                  </g>
                  <g transform="rotate(44 61.546 392.623)">
                    <mask id="welcome-h" fill="#fff">
                      <use xlink:href="#welcome-g" />
                    </mask>
                    <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                    <path
                      fill="url(#welcome-c)"
                      mask="url(#welcome-h)"
                      d="M40.333-15.147h50v95h-50z"
                    />
                  </g>
                </g>
              </svg>
            </div>
            <div class="relative">
              <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">
                {{ greeting() }},
                {{ user && user.name ? user.name : 'Registered User' }}! 👋
              </h1>
              <p>Here is what’s happening with your projects today:</p>
            </div>
          </div>
        </div>
        <!--        <div class="mx-auto max-w-screen-lg text-gray-900">-->
        <!--          <div class="flex justify-center">-->
        <!--            <div class="flex-1">-->
        <!--              <div class="w-auto rounded border dark:border-gray-600">-->
        <!--                <div-->
        <!--                  class="border-b p-4 font-semibold dark:border-gray-600 dark:text-gray-200"-->
        <!--                >-->
        <!--                  Dashboard-->
        <!--                </div>-->
        <!--                <div-->
        <!--                  class="rounded bg-white p-4 dark:bg-slate-800 dark:text-gray-300"-->
        <!--                >-->
        <!--                  <h1 class="mt-4 mb-4 text-center text-2xl">-->
        <!--                    {{ greeting() }},-->
        <!--                    {{ user && user.name ? user.name : 'Registered User' }}!-->
        <!--                  </h1>-->
        <!--                  <div v-if="roles" class="mb-6 text-center">-->
        <!--                    <hr class="mx-auto mb-3 w-10" />-->
        <!--                    <h2 class="mb-5">Your Roles</h2>-->
        <!--                    <RolesBadges :roles="roles" />-->
        <!--                  </div>-->

        <!--                  <div v-if="socialLoginsEnabled">-->
        <!--                    <router-link-->
        <!--                      v-tippy="'Go to application service providers'"-->
        <!--                      :to="{ name: 'account' }"-->
        <!--                    >-->
        <!--                      <div-->
        <!--                        v-if="user.providers.length == 0"-->
        <!--                        class="rounded-lg bg-slate-100 p-10 text-center text-gray-600 transition duration-200 ease-in-out hover:bg-slate-200 hover:text-gray-800 dark:bg-slate-900 hover:dark:bg-slate-700 hover:dark:text-white"-->
        <!--                      >-->
        <!--                        <div>-->
        <!--                          <PowerIcon class="ml-auto mr-auto mb-4 h-12 w-12" />-->
        <!--                        </div>-->
        <!--                        <h2 class="text-lg">-->
        <!--                          No applications are integrated into your account.-->
        <!--                        </h2>-->
        <!--                      </div>-->
        <!--                      <div v-if="user.providers.length > 0">-->
        <!--                        <hr class="mx-auto mb-3 w-10" />-->
        <!--                        <h3 class="mb-5 text-center">-->
        <!--                          {{ user.providers.length }} Application-->
        <!--                          {{ user.providers.length != 1 ? 's' : '' }} integrated-->
        <!--                          into your account-->
        <!--                        </h3>-->
        <!--                        <div-->
        <!--                          class="grid grid-cols-2 gap-4 rounded-lg text-center font-mono text-sm font-bold leading-6 text-white sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5"-->
        <!--                        >-->
        <!--                          <div-->
        <!--                            v-for="(provider, index) in enabledProviders"-->
        <!--                            :key="provider + '_' + index"-->
        <!--                            class="mb-1 w-full rounded-lg border border-gray-200 bg-white shadow-md hover:bg-gray-50 dark:border-gray-900 dark:bg-gray-900 hover:dark:bg-slate-700"-->
        <!--                          >-->
        <!--                            <div-->
        <!--                              class="flex flex-col items-center pt-4 pb-4 pl-2 pr-2"-->
        <!--                            >-->
        <!--                              <span-->
        <!--                                class="fa-4x mb-2"-->
        <!--                                :class="providerIcon(provider.provider)"-->
        <!--                              />-->
        <!--                              <h5-->
        <!--                                class="mb-0 text-lg font-extrabold capitalize text-gray-900 dark:text-white"-->
        <!--                              >-->
        <!--                                {{ provider.provider }}-->
        <!--                              </h5>-->
        <!--                              <div-->
        <!--                                v-if="provider.created_at"-->
        <!--                                class="mb-1 mb-3 text-gray-600 dark:text-gray-400"-->
        <!--                                style="line-height: 1.2; font-size: 0.6em"-->
        <!--                              >-->
        <!--                                <span-->
        <!--                                  class="font-bold uppercase text-gray-700 dark:text-gray-200"-->
        <!--                                >-->
        <!--                                  <span class="far fa-clock" /> First Used:-->
        <!--                                </span>-->
        <!--                                <br />-->
        <!--                                {{ parseDisplayDate(provider.created_at) }}-->
        <!--                              </div>-->
        <!--                              <div-->
        <!--                                v-if="provider.updated_at"-->
        <!--                                class="mb-0 text-gray-600 dark:text-gray-400"-->
        <!--                                style="line-height: 1.2; font-size: 0.6em"-->
        <!--                              >-->
        <!--                                <span-->
        <!--                                  class="font-bold uppercase text-gray-700 dark:text-gray-200"-->
        <!--                                >-->
        <!--                                  <span class="far fa-clock" /> Last Used:-->
        <!--                                </span>-->
        <!--                                <br />-->
        <!--                                {{ parseDisplayDate(provider.updated_at) }}-->
        <!--                              </div>-->
        <!--                            </div>-->
        <!--                          </div>-->
        <!--                        </div>-->
        <!--                      </div>-->
        <!--                    </router-link>-->
        <!--                  </div>-->
        <!--                </div>-->
        <!--              </div>-->

        <!--              <div class="mt-3 mb-5 p-5 text-center">-->
        <!--                <GHButtons-->
        <!--                  show-follow-->
        <!--                  show-star-->
        <!--                  show-fork-->
        <!--                  show-issue-->
        <!--                  show-watch-->
        <!--                  show-sponsor-->
        <!--                  show-download-->
        <!--                  show-count-->
        <!--                  show-tips-->
        <!--                />-->
        <!--              </div>-->
        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->
      </main>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';
import RolesBadges from '@components/roles/RolesBadges.vue';
import { greeting, providerIcon, parseDisplayDate } from '@services/common';
import { PowerIcon } from '@heroicons/vue/24/outline';
import GHButtons from '@components/GHButtons.vue';
import Sidebar from '@/components/Sidebar.vue';
import NavBar from '@/components/NavBar.vue';
import { ref } from 'vue';

export default {
  name: 'Dashboard',
  components: {
    NavBar,
    Sidebar,
    RolesBadges,
    PowerIcon,
    GHButtons,
  },
  setup() {
    const sidebarOpen = ref(false);

    return {
      sidebarOpen,
    };
  },
  data() {
    return {};
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
    isAdminPage() {
      if (
        this.currentRouteName == 'admin' ||
        this.currentRouteName == 'roles' ||
        this.currentRouteName == 'permissions' ||
        this.currentRouteName == 'settings' ||
        this.currentRouteName == 'users' ||
        this.currentRouteName == 'app-settings' ||
        this.currentRouteName == 'phpinfo'
      ) {
        return true;
      }
      return false;
    },
    socialLoginsEnabled() {
      if (Object.values(this.logins).find((v) => v == '1')) {
        return true;
      }
      return false;
    },
    allowedProviders() {
      const providers = [];
      for (const key in this.logins) {
        if (this.logins[key] != false && this.logins[key] != '0') {
          providers.push(key);
        }
      }
      return providers.sort();
    },
    enabledProviders() {
      const providers = [];
      this.user.providers.forEach((provider, index) => {
        const found = this.allowedProviders.find((p) => p == provider.provider);
        if (found) {
          providers.push(provider);
        }
      });
      return providers;
    },
    disabledProviders() {
      let providers = this.allowedProviders;
      this.user.providers.forEach((provider, index) => {
        providers = providers.filter((p) => p != provider.provider);
      });
      return providers;
    },
  },
  methods: {
    greeting,
    providerIcon,
    parseDisplayDate,
  },
};
</script>
