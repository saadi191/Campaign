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
            :to="{ name: 'admin.moderation.pending' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Pending Participants
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Pending Participants ✨
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
          <div class="flex items-center justify-between mb-4">
            <h5
              class="text-xl font-bold leading-none dark:text-white"
              style="color: #483d8b"
            >
              {{ participant.leaflet.participant.fullname }}
            </h5>
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
                      Leaflet Code
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.leaflet.code }}
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
                    {{ participant.leaflet.participant.mobile }}
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
                    v-if="participant.leaflet.participant.city == 0"
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.leaflet.participant.othercity }}
                  </div>

                  <div
                    v-else
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.leaflet.participant.CityName }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Approved
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.updatedDateHumanReadable }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Registered on
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.CreatedTime }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Accepted on
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.UpdatedTime }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Responded in
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.ModeratorTime }}
                  </div>
                </div>
              </li>
            </ul>
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
import { mapGetters } from 'vuex';
import axios from 'axios';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
// import lity from 'lity';
// import LoadingForm from '~admin/components/LoadingForm';
// import pagination from '~admin/components/PaginationComponent';

export default {
  name: 'PendingModeration',
  components: {
    ChevronRightIcon,
    // LoadingForm,
    // pagination,
  },
  layout: 'admin',
  middleware: 'check-auth',
  metaInfo() {
    return { title: 'Admin' };
  },
  data() {
    return {
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
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
    }),
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
      axios
        .post('/api/admin/moderation/pending?search=' + this.search)
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
    banParticipant(id) {
      $('#ban' + id).modal('hide');
      this.isLoading = true;
      axios
        .post('/api/admin/moderation/ban/' + id)
        .then((response) => {
          this.isLoading = false;
          this.$toast.success('Participant successfully banned');
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    deleteParticipant(id) {
      $('#reject' + id).modal('hide');
      this.isLoading = true;
      axios
        .post('/api/admin/moderation/reject/sms/' + id)
        .then((response) => {
          this.isLoading = false;
          this.$toast.success('Participant successfully deleted');
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    acceptParticipant(id) {
      this.isLoading = true;
      $('#approve' + id).modal('hide');
      axios
        .post('/api/admin/moderation/accept/sms/' + id)
        .then((response) => {
          this.isLoading = false;
          this.$toast.success('Participant Approved');
          this.fetchParticipants();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toast.error('Something went wrong! Please try again later.');
        });
    },
    fetchParticipants() {
      const _this = this;
      this.isLoading = true;

      if (this.search !== '') {
        axios
          .post(
            '/api/admin/moderation/pending?page=' +
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
          .post(
            '/api/admin/moderation/pending?page=' +
              this.pagination.current_page,
          )
          .then((result) => {
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
