<template>
  <div
    class="bg-white shadow-lg rounded-sm border border-slate-200 relative"
    style="margin-top: 5%; margin: 5%"
  >
    <header class="px-5 py-4">
      <h2 class="font-semibold text-slate-800">
        Gifts Inventory ({{ total }})
      </h2>
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
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">#</div>
              </th>

              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">Edit</div>
              </th>

              <th
                v-for="(column, indexColumn) in columns"
                :key="indexColumn"
                class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"
              >
                <div class="font-semibold text-left">
                  {{ column }}
                </div>
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

          <template v-for="(gift, indexGift) in gifts" :key="indexGift">
            <tbody class="text-sm">
              <tr>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div>#{{ indexGift + 1 }}</div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <button
                    type="button"
                    class="px-2 py-1 bg-indigo-500 hover:bg-indigo-800 text-white hover:text-white rounded transition duration-300"
                    @click="toggleEdit(gift)"
                  >
                    {{ gift.isEditable ? 'save' : 'edit' }}
                  </button>
                </td>

                <td
                  v-for="(column, indexColumn) in columns"
                  :key="indexColumn"
                  class="px-1 py-1 first:pl-2 last:pr-2 whitespace-nowrap"
                >
                  <input
                    v-model="gift[column]"
                    :readonly="!gift.isEditable"
                    :class="{
                      editable: gift.isEditable,
                      'w-100': column === 'name',
                      'w-20': column !== 'name',
                      'h-8': column === 'name',
                      'bg-gray-100': !gift.isEditable, // Add your choice color class here
                      'border-slate-200': !gift.isEditable, // Border color when readonly
                      'text-gray-500': !gift.isEditable, // Text color when readonly
                    }"
                    class="px-1 py-1 rounded border border-slate-200"
                    placeholder="QTY"
                  />
                </td>
              </tr>
            </tbody>
          </template>
        </table>
      </div>
    </div>
  </div>
  <Pagination
    :pagination="pagination"
    :offset="4"
    class="mt-5"
    :perpage="perPage"
    @paginate="handlePageChange"
  />
</template>

<script lang="ts">
import { mapGetters, mapActions } from 'vuex';
import Pagination from '../Pagination.vue';
import axios from 'axios';
import DeleteConfirmationModal from '../DeleteConfirmationModal.vue';
import swal from 'sweetalert2';

export default {
  name: 'InventoryTable',
  components: {
    Pagination,
    DeleteConfirmationModal,
  },
  props: {
    pagination: {
      type: Object,
      default() {
        return {};
      },
    },

    total: {
      type: Number,
      default() {
        return 0;
      },
    },
    gifts: {
      type: Array,
      default() {
        return [];
      },
    },

    columns: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  setup() {
    return {};
  },
  data() {
    return {
      offset: 4,
      showDeleteConfirmation: {},
      perPage: 10,
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
    updateInventory(gift) {
      // console.log('check', gift);
      this.$emit('update-inventory', gift);
    },
    toggleEdit(gift) {
      gift.isEditable = !gift.isEditable;
      this.updateInventory(gift);
    },

    toCapitalize(value) {
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
    ...mapActions({
      popToast: 'toast/popToast',
    }),

    handlePageChange(page) {
      this.$emit('pageChange', page);
    },
  },
};
</script>
