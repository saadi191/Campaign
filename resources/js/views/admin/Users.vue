<template>
  <div
    id="users"
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
            :to="{ name: 'users' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Users
            </span>
          </router-link>
        </li>
      </ol>
      <!--      <PerPage-->
      <!--        :items="users"-->
      <!--        :per-page="perPage"-->
      <!--        class="float-right mb-2"-->
      <!--        style="margin-top: -0.5em"-->
      <!--        @changed="perPageChanged"-->
      <!--      />-->
    </nav>

    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Users ✨
      </h1>
    </div>
    <Button
      v-tippy="'Create User'"
      class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right"
      :disabled="showCreateUserForm || !dataReady"
      style="margin-right: 5%"
      @click="triggerCreateUser"
    >
      <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
        <path
          d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"
        />
      </svg>
      <span class="xs:block ml-2">Add Users</span>
    </Button>

    <!--    <AppButton-->
    <!--      v-tippy="'Create User'"-->
    <!--      :disabled="showCreateUserForm || !dataReady"-->
    <!--      class="float-right mb-2 px-2 py-2 text-sm font-medium"-->
    <!--      @click="triggerCreateUser"-->
    <!--    >-->
    <!--      <template #text>-->
    <!--        <UserPlusIcon v-if="dataReady" class="ml-2 mr-2 mt-0 h-4 w-4" />-->
    <!--        <CircleSvg v-if="!dataReady" class="ml-2 mr-2 mt-0 h-4 w-4" />-->
    <!--        <span class="sr-only">Create New User</span>-->
    <!--      </template>-->
    <!--    </AppButton>-->

    <!--    <Button-->
    <!--      v-tippy="'Create User'"-->
    <!--      class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right float-right mb-2 px-2 py-2 text-sm font-medium"-->
    <!--      :disabled="showCreateUserForm || !dataReady"-->
    <!--      @click="triggerCreateUser"-->
    <!--    >-->
    <!--      <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">-->
    <!--        <path-->
    <!--          d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"-->
    <!--        />-->
    <!--      </svg>-->
    <!--      <span class="xs:block ml-2">Add User</span>-->
    <!--    </Button>-->

    <UsersTable
      :users="users"
      :pagination="pagination"
      :per-page="perPage"
      :data-ready="dataReady"
      :available-roles="availableRoles"
      :lock-jiggled="lockJigled"
      @get-users="getUsers"
      @confirm-un-verify-user="confirmUnVerifyUser"
      @confirm-verify-user="confirmVerifyUser"
      @delete-user="deleteUser"
      @edit-user="editUser"
      @send-user-verification="sendUserVerification"
      @impersonate-user-triggered="impersonateUserTriggered"
    />

    <UserFormModal
      :key="userFormKey"
      :showing-form="showCreateUserForm"
      :user="userEditing"
      :new-user="creatingNewUser"
      :available-roles="availableRoles"
      @close-modal="closeUserForm"
      @user-created="userCreated"
      @user-updated="userUpdated"
    />
  </div>
</template>

<script lang="ts">
import { ChevronRightIcon, UserPlusIcon } from '@heroicons/vue/24/outline';
import CircleSvg from '@components/CircleSvg.vue';
import { mapGetters, mapActions } from 'vuex';
import axios from 'axios';
import PerPage from '@components/PerPage.vue';
import UsersTable from '@components/admin/UsersTable.vue';
import UserFormModal from '@components/users/UserFormModal.vue';

export default {
  name: 'Users',
  components: {
    ChevronRightIcon,
    // PerPage,
    UsersTable,
    UserPlusIcon,
    CircleSvg,
    UserFormModal,
  },
  props: {},
  setup() {
    return {};
  },
  data() {
    return {
      users: [],
      pagination: {},
      perPage: 10,
      dataReady: false,
      showCreateUserForm: false,
      userEditing: null,
      creatingNewUser: false,
      userFormKey: 432489,
      availableRoles: [],
      rolesDataReady: false,
      lockJigled: false,
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
    this.getUsers();
  },
  beforeUnmount() {},
  updated() {},
  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
      verifyResend: 'auth/verifyResend',
      impersonateUser: 'auth/impersonateUser',
    }),
    perPageChanged(value) {
      this.perPage = parseInt(value);
      this.pagination.current_page = 1;
      this.getUsers();
    },
    async getUsers(updatedPage = null) {
      if (updatedPage) {
        this.pagination.current_page = updatedPage;
      }
      await axios
        .get(
          `/api/users?page=${this.pagination.current_page}&per=${this.perPage}`,
        )
        .then(({ data }) => {
          this.users = data.data;
          delete data.data;
          this.pagination = data;
          this.dataReady = true;
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Getting Users',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
      this.dataReady = true;
    },
    async confirmUnVerifyUser(value) {
      await axios
        .post('/api/users/toggle-verify', {
          action: 'unVerifyUser',
          user: value,
        })
        .then(({ data }) => {
          this.users = this.users.map((u) => (u.id !== data.id ? u : data));
          this.popToast({
            message: 'Successfully Un-Verified!',
            timer: 5000,
            icon: 'warning',
          });
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Un-Verifying User',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
    },
    async confirmVerifyUser(value) {
      await axios
        .post('/api/users/toggle-verify', {
          action: 'confirmVerifyUser',
          user: value,
        })
        .then(({ data }) => {
          this.users = this.users.map((u) => (u.id !== data.id ? u : data));
          this.popToast({
            message: 'Successfully Verified!',
            timer: 5000,
            icon: 'success',
          });
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Verifying User',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
    },
    async deleteUser(value) {
      await axios
        .delete(`/api/users/delete/user/${value.id}`)
        .then(({ data }) => {
          this.users = this.users.filter((u) => u.id != data.id);
          this.popToast({
            message: 'Successfully Deleted!',
            timer: 5000,
            icon: 'success',
          });
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Deleting User',
            timer: 5000,
            icon: 'error',
          });
          this.dataReady = true;
        });
    },
    async getRoles() {
      this.rolesDataReady = false;
      await axios
        .get('/api/roles')
        .then(({ data }) => {
          this.availableRoles = data.roles;
          this.rolesDataReady = true;
        })
        .catch(({ response }) => {
          this.popToast({
            message: 'Error Getting Roles',
            timer: 5000,
            icon: 'error',
          });
          this.rolesDataReady = true;
        });
    },
    triggerCreateUser() {
      this.userFormKey += 1;
      this.creatingNewUser = true;
      this.showCreateUserForm = true;
      this.userEditing = null;
    },
    triggerUpdateUser(user) {
      this.creatingNewUser = false;
      this.userEditing = user;
    },
    userCreated(data) {
      this.users.push(data);
      this.getUsers(); // Realign just in case.
      this.closeUserForm();
    },
    userUpdated(data) {
      this.users = this.users.map((u) => (u.id !== data.id ? u : data));
      this.getUsers(); // Realign just in case.
      this.jiggleTheLock();
      this.closeUserForm();
    },
    jiggleTheLock() {
      const self = this;
      self.lockJigled = true;
      setTimeout(() => {
        self.lockJigled = false;
      }, 1);
    },
    closeUserForm() {
      this.userEditing = null;
      this.creatingNewUser = false;
      this.showCreateUserForm = false;
    },
    editUser(user) {
      console.log('editUser');
      this.userFormKey += 1;
      this.userEditing = user;
      this.creatingNewUser = false;
      this.showCreateUserForm = true;
    },
    async sendUserVerification(user) {
      try {
        await this.verifyResend({ id: user.id }).then((response) => {
          this.popToast({
            message: 'Email sent.',
            timer: 5000,
            icon: 'success',
          });
        });
      } catch (e) {
        this.popToast({
          message: 'An errored, please try again later.',
          timer: 5000,
          icon: 'error',
        });
      }
    },
    async impersonateUserTriggered(user) {
      try {
        await this.impersonateUser({ user }).then((response) => {
          //
        });
      } catch (e) {
        this.popToast({
          message: 'Unable To Impersonate User',
          timer: 5000,
          icon: 'error',
        });
      }
    },
  },
};
</script>

<style scoped>
input:focus,
select:focus,
textarea:focus,
button:focus,
option:focus {
  outline: none !important;
  border: none !important;
}
</style>
<style lang="scss" scoped></style>
