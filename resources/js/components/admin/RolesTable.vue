<template>
  <div
    class="bg-white shadow-lg rounded-sm border border-slate-200 relative"
    style="margin: 7%"
  >
    <header class="px-5 py-4">
      <h2 class="font-semibold text-slate-800">All Roles</h2>
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
                <div class="font-semibold text-left">ID</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Name</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Slug</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Description</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Level</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Created At</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Updated At</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Users</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Permissions</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">Actions</div>
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

          <template v-for="role in rolesData" :key="role.id">
            <RolesTableRow
              :role="role"
              :data-ready="dataReady"
              :lock-jiggled="lockJiggled"
              @edit-role="editRole"
              @delete-role="deleteRole"
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
  <Pagination
    :pagination="pagination"
    :offset="4"
    class="mt-5"
    @paginate="getRoles"
  />
</template>

<script lang="ts">
import { mapGetters, mapActions } from 'vuex';
import Pagination from '@components/Pagination.vue';
import RolesTableRow from '@components/admin/RolesTableRow.vue';
import UsersTableRow from '@/components/admin/UsersTableRow.vue';

export default {
  name: 'RolesTable',
  components: {
    UsersTableRow,
    Pagination,
    RolesTableRow,
  },
  props: {
    dataReady: { type: Boolean, default: false },
    lockJiggled: { type: Boolean, default: false },
    rolesData: {
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
    getRoles(data) {
      this.$emit('getRoles', data);
    },
    deleteRole(value) {
      this.$emit('deleteRole', value);
    },
    editRole(value) {
      this.$emit('editRole', value);
    },
  },
};
</script>
