<template>
  <div
    class="flex flex-nowrap overflow-x-scroll no-scrollbar md:block md:overflow-auto px-3 py-6 border-b md:border-b-0 md:border-r border-slate-200 min-w-60 md:space-y-3"
  >
    <!-- Group 1 -->
    <div>
      <div class="text-xs font-semibold text-slate-400 uppercase mb-3">
        Business settings
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
              :class="
                activeTab === 'authentication'
                  ? 'text-indigo-500'
                  : 'hover:text-slate-700'
              "
            >
              Authentication
            </span>
          </a>
        </li>
        <li
          class="mr-0.5 md:mr-0 md:mb-0.5"
          :class="{ active: activeTab === 'analytics' }"
          @click="activateTab('analytics')"
        >
          <a
            class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
            @click="activateTab('notifications')"
          >
            <span
              class="text-sm font-medium text-slate-600"
              :class="
                activeTab === 'notifications'
                  ? 'text-indigo-500'
                  : 'hover:text-slate-700'
              "
            >
              Analytics
            </span>
          </a>
        </li>
        <!-- Add similar tabs for other sections -->
      </ul>
      <div class="content">
        <AccountPanel v-if="activeTab === 'authentication'" />
        <Success v-if="activeTab === 'analytics'" />
        <!-- Add more components for other sections -->
      </div>
    </div>
  </div>
</template>

<script>
import AccountPanel from '@/components/AccountPanel.vue';
import Success from '@/components/Success.vue';

export default {
  name: 'SettingsSidebar',
  components: { Success, AccountPanel },
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
