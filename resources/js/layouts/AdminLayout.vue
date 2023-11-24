<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <Sidebar :sidebar-open="sidebarOpen" @close-sidebar="sidebarOpen = false" />
    <div
      class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
    >
      <NavBar />
      <main>
        <div class="mb-20 bg-white dark:bg-slate-800">
          <router-view />
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import AdminNavBar from '@components/admin/AdminNavBar.vue';
import AdminSidebar from '@components/admin/AdminSidebar.vue';
import AppFooter from '@components/AppFooter.vue';
import Sidebar from '@/components/Sidebar.vue';
import NavBar from '@/components/NavBar.vue';

export default {
  name: 'AdminLayout',
  components: {
    NavBar,
    Sidebar,
    AdminNavBar,
    AdminSidebar,
    AppFooter,
  },
  props: {},
  setup() {
    return {};
  },
  data() {
    return {
      //
    };
  },
  computed: {
    ...mapState('sidebar', {
      sideBarOpen: (state) => state.sideBarOpen,
      fullScreenSideBarOpen: (state) => state.fullScreenSideBarOpen,
    }),
  },
  watch: {},
  created() {},
  mounted() {},
  beforeUnmount() {},
  updated() {},
  methods: {},
};
</script>

<style scoped></style>
<style lang="scss" scoped></style>
