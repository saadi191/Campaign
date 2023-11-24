<template>
  <div
    id="roles"
    class="bg-white p-3 dark:bg-slate-800 dark:text-gray-200"
    style="background-color: #f1f5f9"
  >
    <nav class="mb-6 text-sm font-semibold" aria-label="Breadcrumb">
      <ol class="inline-flex list-none p-0">
        <li class="flex items-center">
          <router-link
            v-if="authenticated && roles && (roles.admin || roles.superAdmin)"
            v-slot="{ isActive }"
            :to="{ name: 'admin' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            Admin
          </router-link>
        </li>
        <li class="flex items-center">
          <ChevronRightIcon class="ml-2 mr-2 mt-0 h-4 w-4" />
        </li>
        <li class="flex items-center">
          <router-link
            v-if="authenticated && roles && (roles.admin || roles.superAdmin)"
            v-slot="{ isActive }"
            :to="{ name: 'roles' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Roles
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Roles ✨
      </h1>
    </div>
    <Button
      v-tippy="'Create Role'"
      :disabled="showCreateRoleForm || !dataReady"
      class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right"
      style="margin-right: 5%"
      @click="triggerCreateRole"
    >
      <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
        <path
          d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"
        />
      </svg>
      <span class="xs:block ml-2">Add Roles</span>
    </Button>
    <RolesTable
      :roles-data="rolesData"
      :pagination="pagination"
      :per-page="perPage"
      :data-ready="dataReady"
      :lock-jiggled="lockJigled"
      @get-roles="getRoles"
      @edit-role="editRole"
      @delete-role="deleteRole"
    />

    <RoleFormModal
      :key="roleFormKey"
      :showing-form="showCreateRoleForm"
      :role="roleEditing"
      :new-role="creatingNewRole"
      :available-permissions="availablePermissions"
      @close-modal="closeRoleForm"
      @role-created="roleCreated"
      @role-updated="roleUpdated"
    />
  </div>
</template>

<script lang="ts">
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import { mapGetters, mapActions } from 'vuex';
import axios from 'axios';
import RolesTable from '@components/admin/RolesTable.vue';
import RoleFormModal from '@components/roles/RoleFormModal.vue';
import CircleSvg from '@components/CircleSvg.vue';
import PerPage from '@components/PerPage.vue';

export default {
  name: 'Roles',
  components: {
    ChevronRightIcon,
    RolesTable,
    RoleFormModal,
    CircleSvg,
    // PerPage,
  },
  props: {},
  setup() {
    return {};
  },
  data() {
    return {
      dataReady: false,
      rolesData: null,
      pagination: {},
      perPage: 25,
      lockJigled: false,
      showCreateRoleForm: false,
      roleEditing: null,
      creatingNewRole: false,
      roleFormKey: 432489,
      availablePermissions: [],
      permissionsDataReady: false,
    };
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
    }),
  },
  watch: {},
  created() {},
  mounted() {
    this.getRoles();
    this.getPermissions();
  },
  beforeUnmount() {},
  updated() {},
  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
    perPageChanged(value) {
      this.perPage = parseInt(value);
      this.pagination.current_page = 1;
      this.getRoles();
    },
    async getRoles(updatedPage = null) {
      if (updatedPage) {
        this.pagination.current_page = updatedPage;
      }
      await axios
        .get(
          `/api/roles-complete?page=${this.pagination.current_page}&per=${this.perPage}`,
        )
        .then(({ data }) => {
          this.rolesData = data.data;
          delete data.data;
          this.pagination = data;
          this.dataReady = true;
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Getting Roles',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
      this.dataReady = true;
    },
    async getPermissions() {
      this.permissionsDataReady = false;
      await axios
        .get('/api/permissions')
        .then(({ data }) => {
          this.availablePermissions = data.permissions;
          this.permissionsDataReady = true;
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Getting Permissions',
            timer: 5000,
            icon: 'error',
          });
          this.permissionsDataReady = true;
        });
      this.permissionsDataReady = true;
    },
    async deleteRole(value) {
      await axios
        .delete(`/api/roles/delete/role/${value.id}`)
        .then(({ data }) => {
          this.rolesData = this.rolesData.filter((u) => u.id != data.id);
          this.popToast({
            message: 'Successfully Deleted Role!',
            timer: 5000,
            icon: 'success',
          });
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Deleting Role',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
    },
    jiggleTheLock() {
      const self = this;
      self.lockJigled = true;
      setTimeout(() => {
        self.lockJigled = false;
      }, 1);
    },
    closeRoleForm() {
      this.roleEditing = null;
      this.creatingNewRole = false;
      this.showCreateRoleForm = false;
    },
    editRole(role) {
      this.roleFormKey += 1;
      this.roleEditing = role;
      this.creatingNewRole = false;
      this.showCreateRoleForm = true;
    },
    roleUpdated(data) {
      this.rolesData = this.rolesData.map((u) => (u.id !== data.id ? u : data));
      this.getRoles(); // Realign just in case.
      this.jiggleTheLock();
      this.closeRoleForm();
    },
    roleCreated(data) {
      this.rolesData.push(data);
      this.getRoles(); // Realign just in case.
      this.closeRoleForm();
    },
    triggerCreateRole() {
      this.roleFormKey += 1;
      this.creatingNewRole = true;
      this.showCreateRoleForm = true;
      this.roleEditing = null;
    },
  },
};
</script>

<style scoped></style>
<style lang="scss" scoped></style>
