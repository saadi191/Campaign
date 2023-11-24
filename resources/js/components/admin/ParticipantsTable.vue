<template>
  <div
    class="bg-white shadow-lg rounded-sm border border-slate-200 relative"
    style="margin-top: 5%; margin: 5%"
  >
    <header class="px-5 py-4">
      <h2 class="font-semibold text-slate-800">
        All Participants ({{ total }})
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
                <div class="font-semibold text-left">GIFT</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">FULL NAME</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">MOBILE</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">CITY</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">LOCATION</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">AGE</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold text-left">PAPER CODE / SERIAL</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">REGISTERED ON:</div>
              </th>
              <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                <div class="font-semibold">ACTION</div>
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

          <template v-for="participant in participants" :key="participant.id">
            <tbody class="text-sm">
              <tr>
                <td
                  v-if="participant.type == 'gift'"
                  class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"
                >
                  <div v-if="participant.gift">{{ participant.gift.name }}</div>
                </td>
                <td
                  v-else-if="participant.type == 'voucher'"
                  class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"
                >
                  <div v-if="participant.voucher">
                    {{ participant.voucher.voucher.image }}
                  </div>
                </td>
                <td
                  v-else
                  class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"
                >
                  <div>Pending Online Raffle</div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div v-if="participant.participant">
                    {{ participant.participant.fullname }}
                  </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div v-if="participant.participant.mobile">
                    {{ participant.participant.mobile }}
                    <button
                      class="px-2 py-1 bg-transparent text-red-500 hover:text-red-600 rounded transition duration-300"
                      @click="
                        showRemoveConfirmation[participant.participant.id] =
                          true
                      "
                    >
                      <i class="fas fa-trash-alt"></i>
                    </button>

                    <remove-number-modal
                      :show="showRemoveConfirmation[participant.participant.id]"
                      :participant="participant"
                      @confirm="handleRemoveConfirmation(participant)"
                      @cancel="
                        showRemoveConfirmation[participant.participant.id] =
                          false
                      "
                    />
                  </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div v-if="participant.participant.get_city">
                    {{ participant.participant.get_city.name }}
                  </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div v-if="participant.location">
                    {{ participant.location.description }}
                  </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div v-if="participant.participant">
                    {{ participant.participant.age }}
                  </div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div>
                    {{ participant.code }}
                    /
                    {{ participant.serial }}
                  </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div v-if="participant.participant">
                    {{ participant.CreatedTime }}
                  </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <button
                      class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white hover:text-white rounded transition duration-300"
                      @click="showDeleteConfirmation[participant.id] = true"
                    >
                      Remove
                    </button>
                  </div>
                  <delete-confirmation-modal
                    :show="showDeleteConfirmation[participant.id]"
                    :participant="participant"
                    @confirm="handleDeleteConfirmation(participant)"
                    @cancel="showDeleteConfirmation[participant.id] = false"
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
    @paginate="handlePageChange"
  />
</template>

<script lang="ts">
import { mapGetters, mapActions } from 'vuex';
import Pagination from '../Pagination.vue';
import axios from 'axios';
import DeleteConfirmationModal from '../DeleteConfirmationModal.vue';
import RemoveNumberModal from '@/components/RemoveNumberModal.vue';
import swal from 'sweetalert2';

export default {
  name: 'ParticipantsTable',
  components: {
    Pagination,
    DeleteConfirmationModal,
    RemoveNumberModal,
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
    participants: {
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
      showRemoveConfirmation: {},
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

    removeNumber(id) {
      this.isLoading = true;
      axios
        .post('/api/admin/participant/remove/' + id)
        .then((response) => {
          this.popToast({
            message: 'Participant removed',
            type: 'success',
          });
          this.$emit('fetchParticipants');
        })
        .catch((error) => {
          this.popToast({
            message: 'Error removing number',
            type: 'error',
          });
        });
    },
    deleteParticipant(participant) {
      // alert(participant.id);
      axios
        .post('/api/admin/participant/leaflet/remove/' + participant.id)
        .then((response) => {
          this.popToast({
            message: 'Leaflet removed',
            type: 'success',
          });
          this.$emit('fetchParticipants');
        })
        .catch((error) => {
          // this.isLoading = false;
          this.popToast({
            message: 'Error removing leaflet',
            type: 'error',
          });
        });
    },

    handleDeleteConfirmation(participant) {
      this.deleteParticipant(participant);
      this.showDeleteConfirmation[participant.id] = false;
    },

    handleRemoveConfirmation(participant) {
      this.removeNumber(participant.participant.id);
      this.showRemoveConfirmation[participant.participant.id] = false;
    },

    handlePageChange(page) {
      this.$emit('pageChange', page);
    },
  },
};
</script>
