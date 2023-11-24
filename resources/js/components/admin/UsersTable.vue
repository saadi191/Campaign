<template>
  <div
    class="bg-white shadow-lg rounded-sm border border-slate-200 relative"
    style="margin: 7%"
  >
    <header class="px-5 py-4">
      <h2 class="font-semibold text-slate-800">All Users</h2>
    </header>
    <div>
      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="table-auto w-full divide-y divide-slate-200">
          <!-- Table header -->
          <thead
            class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-slate-200"
          >
            <tr>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                <div class="flex items-center">
                  <label class="inline-flex">
                    <span class="sr-only">Select all</span>
                    <input
                      v-model="selectAll"
                      class="form-checkbox"
                      type="checkbox"
                      @click="checkAll"
                    />
                  </label>
                </div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">User</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Email</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Role(s)</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Status</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Created At</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Action</div>
              </th>
            </tr>
          </thead>
          <!-- Table body -->
          <!--                    <Order-->
          <!--                      v-for="order in orders"-->
          <!--                      :key="order.id"-->
          <!--                      :order="order"-->
          <!--                      v-model:selected="selected"-->
          <!--                      :value="order.id"-->
          <!--                    />-->

          <template v-for="user in users" :key="user.id">
            <UsersTableRow
              :user="user"
              :data-ready="dataReady"
              :available-roles="availableRoles"
              :lock-jiggled="lockJiggled"
              @confirm-un-verify-user="confirmUnVerifyUser"
              @confirm-verify-user="confirmVerifyUser"
              @delete-user="deleteUser"
              @edit-user="editUser"
              @send-user-verification="sendUserVerification"
              @impersonate-user-triggered="impersonateUserTriggered"
            />
          </template>

          <!--          <UsersTableRow-->
          <!--            v-for="user in users"-->
          <!--            :key="user.id"-->
          <!--            :user="user"-->
          <!--            @delete-user="deleteUser"-->
          <!--            @edit-user="editUser"-->
          <!--          />-->
        </table>
      </div>
    </div>
  </div>
  <!--  <div class="overflow-x-scroll rounded-lg shadow" style="width: 100%">-->
  <!--    <table class="min-w-full leading-normal" aria-describedby="Users Table">-->
  <!--      <thead>-->
  <!--        <tr-->
  <!--          class="border-b-2 border-gray-300 bg-gray-200 text-gray-600 dark:border-gray-500 dark:bg-slate-900 dark:text-gray-200"-->
  <!--          style="background-color: #f8fafc"-->
  <!--        >-->
  <!--          <th-->
  <!--            class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider"-->
  <!--          >-->
  <!--            User-->
  <!--          </th>-->
  <!--          <th-->
  <!--            class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider"-->
  <!--          >-->
  <!--            Email-->
  <!--          </th>-->
  <!--          <th-->
  <!--            class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider"-->
  <!--          >-->
  <!--            Role(s)-->
  <!--          </th>-->
  <!--          <th-->
  <!--            class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider"-->
  <!--          >-->
  <!--            Created at-->
  <!--          </th>-->
  <!--          <th-->
  <!--            class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider"-->
  <!--          >-->
  <!--            Status-->
  <!--          </th>-->
  <!--          <th-->
  <!--            class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider"-->
  <!--          >-->
  <!--            Actions-->
  <!--          </th>-->
  <!--        </tr>-->
  <!--      </thead>-->
  <!--      <tbody v-if="dataReady" style="background-color: white">-->
  <!--        <template v-for="user in users" :key="user.id">-->
  <!--          <UsersTableRow-->
  <!--            :user="user"-->
  <!--            :data-ready="dataReady"-->
  <!--            :available-roles="availableRoles"-->
  <!--            :lock-jiggled="lockJiggled"-->
  <!--            @confirm-un-verify-user="confirmUnVerifyUser"-->
  <!--            @confirm-verify-user="confirmVerifyUser"-->
  <!--            @delete-user="deleteUser"-->
  <!--            @edit-user="editUser"-->
  <!--            @send-user-verification="sendUserVerification"-->
  <!--            @impersonate-user-triggered="impersonateUserTriggered"-->
  <!--          />-->
  <!--        </template>-->
  <!--      </tbody>-->
  <!--      <tbody v-if="!dataReady">-->
  <!--        <tr-->
  <!--          class="bg-gray-100 text-gray-900 dark:bg-slate-700 dark:text-gray-100"-->
  <!--        >-->
  <!--          <td colspan="6" class="pt-10 pb-10 text-center">-->
  <!--            <span class="fa fa-circle-notch fa-spin fa-5x text-gray-400" />-->
  <!--          </td>-->
  <!--        </tr>-->
  <!--      </tbody>-->
  <!--    </table>-->
  <!--    <div-->
  <!--      v-if="dataReady && users && users.length >= 1"-->
  <!--      class="xs:flex-row xs:justify-between flex flex-col items-center px-3 py-3 dark:bg-slate-700"-->
  <!--    >-->
  <Pagination
    :pagination="pagination"
    :offset="4"
    class="mt-5"
    @paginate="getUsers"
  />
  <!--    </div>-->
  <!--  </div>-->
</template>

<script lang="ts">
import { mapGetters, mapActions } from 'vuex';
import Pagination from '@/components/Pagination.vue';
import UsersTableRow from './UsersTableRow.vue';

export default {
  name: 'UsersTable',
  components: {
    Pagination,
    UsersTableRow,
  },
  props: {
    dataReady: { type: Boolean, default: false },
    lockJiggled: { type: Boolean, default: false },
    users: {
      type: Array,
      default() {
        return [];
      },
    },
    pagination: {
      type: Object,
      default() {
        return {};
      },
    },
    availableRoles: { type: Array, default: null },
  },
  setup() {
    return {};
  },
  data() {
    return {
      offset: 4,
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
  mounted() {},
  beforeUnmount() {},
  updated() {},
  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
    getUsers(data) {
      this.$emit('getUsers', data);
    },
    confirmUnVerifyUser(value) {
      this.$emit('confirmUnVerifyUser', value);
    },
    confirmVerifyUser(value) {
      this.$emit('confirmVerifyUser', value);
    },
    deleteUser(value) {
      this.$emit('deleteUser', value);
    },
    editUser(value) {
      this.$emit('editUser', value);
    },
    sendUserVerification(value) {
      this.$emit('sendUserVerification', value);
    },
    impersonateUserTriggered(value) {
      this.$emit('impersonateUserTriggered', value);
    },
  },
};
</script>
