<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <Sidebar />
    <div
      class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
    >
      <NavBar />
      <main style="background-color: #f1f5f9">
        <div
          class="flex h-screen overflow-hidden"
          style="background-color: #f1f5f9"
        >
          <!-- Sidebar -->

          <!-- Content area -->
          <div
            class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
          >
            <!-- Site header -->

            <main>
              <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                <!-- Page header -->
                <div class="mb-8">
                  <!-- Title -->
                  <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                    Account Settings ✨
                  </h1>
                </div>

                <!-- Content -->
                <div class="bg-white shadow-lg rounded-sm mb-8">
                  <div class="flex flex-col md:flex-row md:-mr-px">
                    <div
                      class="flex flex-nowrap overflow-x-scroll no-scrollbar md:block md:overflow-auto px-3 py-6 border-b md:border-b-0 md:border-r border-slate-200 min-w-60 md:space-y-3"
                    >
                      <!-- Group 1 -->
                      <div>
                        <div
                          class="text-xs font-semibold text-slate-400 uppercase mb-3"
                        >
                          Account Settings
                        </div>
                        <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
                          <li
                            class="mr-0.5 md:mr-0 md:mb-0.5"
                            :class="{ active: activeTab === 'account' }"
                            @click="activateTab('account')"
                          >
                            <a
                              class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                              @click="activateTab('account')"
                            >
                              <span
                                class="text-sm font-medium text-slate-600"
                                :class="{
                                  'text-blue': activeTab === 'account',
                                }"
                              >
                                Account
                              </span>
                            </a>
                          </li>
                          <li
                            class="mr-0.5 md:mr-0 md:mb-0.5"
                            :class="{
                              'text-indigo-500': activeTab === 'profile',
                            }"
                            @click="activateTab('profile')"
                          >
                            <a
                              class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                              @click="activateTab('profile')"
                            >
                              <span
                                class="text-sm font-medium text-slate-600"
                                :class="{
                                  'text-blue': activeTab === 'profile',
                                }"
                              >
                                Profile
                              </span>
                            </a>
                          </li>

                          <li
                            class="mr-0.5 md:mr-0 md:mb-0.5"
                            :class="{ active: activeTab === 'password' }"
                            @click="activateTab('password')"
                          >
                            <a
                              class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                              @click="activateTab('password')"
                            >
                              <span
                                class="text-sm font-medium text-slate-600"
                                :class="{
                                  'text-blue': activeTab === 'password',
                                }"
                              >
                                Password
                              </span>
                            </a>
                          </li>

                          <!-- Add similar tabs for other sections -->
                        </ul>
                      </div>
                    </div>

                    <Account v-if="activeTab === 'account'" />
                    <Profile v-if="activeTab === 'profile'" />
                    <Password v-if="activeTab === 'password'" />
                  </div>
                </div>
              </div>
            </main>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import AccountPanel from '@/components/AccountPanel.vue';
import Success from '@/components/Success.vue';
import Analytics from '@/components/Analytics.vue';
import Monitoring from '@/components/Monitoring.vue';
import AppMeta from '@/components/AppMeta.vue';
import Secrets from '@/components/Secrets.vue';
import Authentication from '@/components/Authentication.vue';
import Sidebar from '@/components/Sidebar.vue';
import NavBar from '@/components/NavBar.vue';
import Profile from '@/components/ProfileSettings/Profile.vue';
import Password from '@/components/ProfileSettings/Password.vue';
import Account from '@/components/ProfileSettings/Account.vue';

export default {
  name: 'ProfileSettings',
  components: {
    Account,
    Password,
    Profile,
    NavBar,
    Sidebar,
    Analytics,
    AccountPanel,
    Monitoring,
    AppMeta,
    Secrets,
    Authentication,
  },
  data() {
    return {
      activeTab: 'account',
    };
  },
  methods: {
    activateTab(tab) {
      this.activeTab = tab;
    },
  },
};
</script>
<style scoped>
.text-blue {
  color: #3b82f6;
}
</style>
