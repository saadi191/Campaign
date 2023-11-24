<template>
  <div class="grow">
    <!-- Panel body -->
    <div class="card p-4 m-4 shadow-black">
      <AccountPanel />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import Sidebar from '@/components/Sidebar.vue';
import AccountPanel from '@/components/AccountPanel.vue';

export default {
  name: 'Account',
  components: {
    AccountPanel,
    Sidebar,
  },
  setup() {
    const sidebarOpen = ref(false);

    return {
      sidebarOpen,
    };
  },
};
</script>
