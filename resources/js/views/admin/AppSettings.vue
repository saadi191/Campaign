<template>
  <div class="flex h-screen overflow-hidden" style="background-color: #f1f5f9">
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
              App Settings ✨
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
                    App settings
                  </div>
                  <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
                    <li
                      class="mr-0.5 md:mr-0 md:mb-0.5"
                      :class="{ active: activeTab === 'authentication' }"
                      @click="activateTab('authentication')"
                    >
                      <a
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        @click="activateTab('authentication')"
                      >
                        <span
                          class="text-sm font-medium text-slate-600"
                          :class="{
                            'text-blue': activeTab === 'authentication',
                          }"
                        >
                          Authentication
                        </span>
                      </a>
                    </li>
                    <li
                      class="mr-0.5 md:mr-0 md:mb-0.5"
                      :class="{ 'text-indigo-500': activeTab === 'analytics' }"
                      @click="activateTab('analytics')"
                    >
                      <a
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        @click="activateTab('analytics')"
                      >
                        <span
                          class="text-sm font-medium text-slate-600"
                          :class="{
                            'text-blue': activeTab === 'analytics',
                          }"
                        >
                          Analytics
                        </span>
                      </a>
                    </li>

                    <li
                      class="mr-0.5 md:mr-0 md:mb-0.5"
                      :class="{ active: activeTab === 'monitoring' }"
                      @click="activateTab('monitoring')"
                    >
                      <a
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        @click="activateTab('monitoring')"
                      >
                        <span
                          class="text-sm font-medium text-slate-600"
                          :class="{
                            'text-blue': activeTab === 'monitoring',
                          }"
                        >
                          Monitoring
                        </span>
                      </a>
                    </li>

                    <li
                      class="mr-0.5 md:mr-0 md:mb-0.5"
                      :class="{ active: activeTab === 'appMeta' }"
                      @click="activateTab('appMeta')"
                    >
                      <a
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        @click="activateTab('appMeta')"
                      >
                        <span
                          class="text-sm font-medium text-slate-600"
                          :class="{
                            'text-blue': activeTab === 'appMeta',
                          }"
                        >
                          App Meta
                        </span>
                      </a>
                    </li>

                    <li
                      class="mr-0.5 md:mr-0 md:mb-0.5"
                      :class="{ active: activeTab === 'secrets' }"
                      @click="activateTab('secrets')"
                    >
                      <a
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        @click="activateTab('secrets')"
                      >
                        <span
                          class="text-sm font-medium text-slate-600"
                          :class="{
                            'text-blue': activeTab === 'secrets',
                          }"
                        >
                          Secrets
                        </span>
                      </a>
                    </li>

                    <!-- Add similar tabs for other sections -->
                  </ul>
                </div>
              </div>

              <Authentication v-if="activeTab === 'authentication'" />
              <Analytics v-if="activeTab === 'analytics'" />
              <Monitoring v-if="activeTab === 'monitoring'" />
              <AppMeta v-if="activeTab === 'appMeta'" />
              <Secrets v-if="activeTab === 'secrets'" />
            </div>
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

export default {
  name: 'AppSettings',
  components: {
    Analytics,
    AccountPanel,
    Monitoring,
    AppMeta,
    Secrets,
    Authentication,
  },
  data() {
    return {
      activeTab: 'authentication', // Set the default active tab
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
