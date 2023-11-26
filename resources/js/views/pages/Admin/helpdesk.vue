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
            :to="{ name: 'view.helpdesk' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Help Desk
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Help Desk ✨
      </h1>
    </div>

    <div
      class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2"
    >
      <form class="relative">
        <label for="action-search" class="sr-only">Search</label>
        <input
          id="action-search"
          v-model="search"
          class="form-input pl-4 focus:border-slate-300 w-[200px]"
          type="search"
          placeholder="Search by Mobile Number"
        />
      </form>
    </div>

    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4"
    >
      <div
        v-for="participant in participants"
        :key="participant.id"
        class="mt-4"
      >
        <div
          class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700"
        >
          <div>
            <i class="fas fa-clock text-gray-400"></i>
            <span class="ml-2 text-sm text-gray-500">{{
              participant.updatedDateHumanReadable
            }}</span>
          </div>
          <div>
            <i class="fas fa-user text-gray-400"></i>
            <span class="ml-2 text-sm text-gray-500">{{
              participant.participant.fullname
            }}</span>
          </div>
          <div class="flow-root">
            <ul
              role="list"
              class="divide-y divide-gray-200 dark:divide-gray-700"
            >
              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Paper Code
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.code }}
                  </div>
                </div>
              </li>
              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Mobile
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.participant.mobile }}
                  </div>
                </div>
              </li>
              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      City
                    </p>
                  </div>
                  <div
                    v-if="participant.participant.city"
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.participant.city.name }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Age
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.participant.age }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <p
                  class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                >
                  WHO USED THE PAPER CODE?
                </p>
                <div
                  class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700"
                >
                  <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4"
                  >
                    <div>
                      <p
                        class="text-sm text-gray-900 font-bold dark:text-white"
                      >
                        Name
                      </p>
                      <p
                        class="text-base font-semibold text-gray-800 dark:text-white text-uppercase"
                      >
                        {{ participant.leaflet.participant.fullname }}
                      </p>
                    </div>
                    <div>
                      <p
                        class="text-sm text-gray-900 font-bold dark:text-white"
                      >
                        Mobile
                      </p>
                      <p
                        class="text-base font-semibold text-gray-800 dark:text-white text-uppercase"
                      >
                        {{ participant.leaflet.participant.mobile }}
                      </p>
                    </div>
                    <div>
                      <p
                        class="text-sm text-gray-900 font-bold dark:text-white"
                      >
                        City
                      </p>
                      <p
                        class="text-base font-semibold text-gray-800 dark:text-white text-uppercase"
                      >
                        {{ participant.leaflet.participant.city.name }}
                      </p>
                    </div>

                    <div>
                      <p
                        class="text-sm text-gray-900 font-bold dark:text-white"
                      >
                        Age
                      </p>
                      <p
                        class="text-base font-semibold text-gray-800 dark:text-white text-uppercase"
                      >
                        {{ participant.leaflet.participant.age }}
                      </p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <div
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2"
            >
              <div>
                <button
                  type="button"
                  class="mr-3 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center"
                  @click="showAcceptConfirmation[participant.id] = true"
                >
                  Accept
                </button>

                <accept-confirmation-modal
                  :show="showAcceptConfirmation[participant.id]"
                  :participant="participant"
                  @confirm="handleAcceptConfirmation(participant)"
                  @cancel="showAcceptConfirmation[participant.id] = false"
                />
              </div>
              <div>
                <button
                  type="button"
                  class="ml-5 text-white bg-rose-500 hover:bg-rose-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center"
                  @click="showRejectConfirmation[participant.id] = true"
                >
                  Reject
                </button>
                <reject-confirmation-modal
                  :show="showRejectConfirmation[participant.id]"
                  :participant="participant"
                  @confirm="handleARejectConfirmation(participant)"
                  @cancel="showRejectConfirmation[participant.id] = false"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="notfound"
      style="
        font-size: 1.5em;
        margin: 150px;
        text-transform: uppercase;
        text-align: center;
      "
    >
      No search found with the mobile number <br /><b>{{ search }}</b>
    </div>

    <div
      v-if="winners"
      style="
        font-size: 1.5em;
        margin: 150px;
        text-transform: uppercase;
        text-align: center;
      "
    >
      No participants yet
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import axios from 'axios';
// import lity from 'lity'
// import LoadingForm from '~admin/components/LoadingForm'
// import pagination from '~admin/components/PaginationComponent'
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import DeleteConfirmationModal from '@/components/DeleteConfirmationModal.vue';
import AcceptConfirmationModal from '@/components/AcceptConfirmationModal.vue';
import RejectConfirmationModal from '@/components/RejectConfirmationModal.vue';
import swal from 'sweetalert2';

export default {
  name: 'Helpdesk',

  components: {
    DeleteConfirmationModal,
    ChevronRightIcon,
    AcceptConfirmationModal,
    RejectConfirmationModal,
    // LoadingForm,
    // pagination
  },
  metaInfo() {
    return { title: 'Admin' };
  },

  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
    }),
  },

  data() {
    return {
      showAcceptConfirmation: {},
      showRejectConfirmation: {},
      // title: window.config.appName,
      participants: [],
      participantsNew: [],
      isLoading: true,

      search: '',
      errors: {},

      currentSort: 'name',
      currentSortDir: 'asc',
      pagination: {
        current_page: 1,
      },
      pageSize: 8,
      currentPage: 1,
      lastPage: '',
      notfound: null,
      winners: '1',
    };
  },

  watch: {
    search: function () {
      const _this = this;
      let _participants = this.participants;
      this.isLoading = true;
      if (this.search !== '') {
        _participants = _participants.filter(
          (c) =>
            c.leaflet.participant.mobile
              .replace('966', '0')
              .toLowerCase()
              .indexOf(this.search.toLowerCase()) >= 0,
        );
      }
      console.log(_participants);
      axios
        .post('/api/admin/help/pending?search=' + this.search)
        .then((result) => {
          this.isLoading = false;
          if (result.data.data.data.length == 0 && this.search !== '') {
            _this.winners = null;
            _this.notfound = '1';
          } else {
            _this.notfound = null;
          }
          if (result.data.data.data > 0) {
            _this.winners = null;
          }
          this.participants = result.data.data.data;
          this.pagination = result.data.pagination;
        })
        .catch((error) => {
          this.isLoading = false;
        });
      this.currentPage = 1;
    },
  },
  mounted() {
    this.fetchParticipants();
  },
  created() {
    if (this.$route.query.page) {
      this.pagination.current_page = this.$route.query.page;
    }
  },

  methods: {
    ...mapActions({
      popToast: 'toast/popToast',
    }),
    deleteParticipant(id) {
      // $('#reject' + id).modal('hide');
      this.isLoading = true;
      axios
        .post('/api/admin/help/reject/sms/' + id)
        .then((response) => {
          this.isLoading = false;
          this.popToast({
            message: 'Leaflet removed',
            type: 'success',
          });
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.popToast({
            message: 'Something went wrong! Please try again later.',
            type: 'error',
          });
        });
    },

    handleARejectConfirmation(participant) {
      this.showRejectConfirmation[participant.id] = false;
      this.deleteParticipant(participant.id);
    },

    handleAcceptConfirmation(participant) {
      this.showAcceptConfirmation[participant.id] = false;
      this.acceptParticipant(participant.id);
    },
    acceptParticipant(id) {
      this.isLoading = true;
      // $('#approve' + id).modal('hide');
      axios
        .post('/api/admin/help/accept/sms/' + id)
        .then((response) => {
          this.isLoading = false;
          this.popToast({
            message: 'Participant Approved',
            type: 'success',
          });
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.popToast({
            message: 'Something went wrong! Please try again later.',
            type: 'error',
          });
        });
    },
    fetchParticipants() {
      const _this = this;
      this.isLoading = true;

      if (this.search !== '') {
        axios
          .post(
            '/api/admin/help/pending?page=' +
              this.pagination.current_page +
              '&search=' +
              this.search,
          )
          .then((result) => {
            this.isLoading = false;
            if (result.data.data.data.length == 0 && this.search !== '') {
              _this.winners = null;
              _this.notfound = '1';
            } else {
              _this.notfound = null;
            }
            if (result.data.data.data > 0) {
              _this.winners = null;
            }
            this.participants = result.data.data.data;
            this.pagination = result.data.pagination;
          })
          .catch((error) => {
            this.isLoading = false;
          });
      } else {
        axios
          .post('/api/admin/help/pending?page=' + this.pagination.current_page)
          .then((result) => {
            console.log('check', result.data.data.data);
            this.isLoading = false;
            if (result.data.data.data.length == 0) {
              _this.winners = '1';
            } else {
              _this.winners = null;
            }
            this.participants = result.data.data.data;
            this.pagination = result.data.pagination;
          })
          .catch((error) => {
            _this.winners = '1';
            this.isLoading = false;
          });
      }
    },
    nextPage: function () {
      if (this.currentPage * this.pageSize < this.participantsNew.length)
        this.currentPage++;
    },
    prevPage: function () {
      if (this.currentPage > 1) this.currentPage--;
    },
  },
};
</script>
