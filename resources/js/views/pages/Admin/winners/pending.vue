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
            :to="{ name: 'admin.winners.pending' }"
            class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-400"
          >
            <span
              :class="[
                isActive &&
                  'cursor-default text-gray-800 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-500',
              ]"
            >
              Winners Pending
            </span>
          </router-link>
        </li>
      </ol>
    </nav>
    <div class="mb-1 sm:mb-0 ml-20">
      <h1 class="text-2xl md:text-3xl text-slate-800 font-bold float-left">
        Pending Gifts ✨
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
      class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4"
    >
      <div
        v-for="participant in filteredList"
        :id="participant.participant.id"
        :key="participant.participant.id"
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
              {{ participant.participant.first_name }}
              {{ participant.participant.middle_name }}
              {{ participant.participant.last_name }}
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
                      Code / Serial
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    Code {{ participant.code }} / Serial
                    {{ participant.serial }}
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
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.participant.get_city.name }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Location
                    </p>
                  </div>
                  <div
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.location.description }}
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      Gift
                    </p>
                  </div>
                  <div
                    v-if="participant.gift"
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.gift.name }}
                  </div>
                  <div
                    v-if="!participant.gift"
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    No gift assigned to this participant
                  </div>
                </div>
              </li>

              <li class="py-3 sm:py-4">
                <div class="flex items-center">
                  <div class="flex-1 min-w-0 ms-4">
                    <p
                      class="text-sm text-gray-900 font-bold truncate dark:text-white text-uppercase"
                    >
                      SKU
                    </p>
                  </div>
                  <div
                    v-if="participant.gift"
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    {{ participant.gift.image }}
                  </div>

                  <div
                    v-if="!participant.gift"
                    class="inline-flex items-center text-base font-semibold text-gray-800 dark:text-white"
                  >
                    No SKU found for this participant
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
      None of the winners claimed their gifts yet
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
// import notyf from 'notyf';
// import lity from 'lity'
// import LoadingForm from '~admin/components/LoadingForm'
// import pagination from '~admin/components/PaginationComponent'

export default {
  name: 'WinnersPending',
  components: {
    // LoadingForm,
    // pagination,
    ChevronRightIcon,
  },
  metaInfo() {
    return { title: 'Admin' };
  },

  data() {
    return {
      // title: window.config.appName,
      participants: [],
      participantsNew: [],
      isLoading: true,
      week: 1,
      verification_code: '',

      // notyf: new Notyf({ delay: 4000 }),
      search: '',
      winners: '1',
      errors: {},

      currentSort: 'name',
      currentSortDir: 'asc',
      pageSize: 8,
      currentPage: 1,
      lastPage: '',
      notfound: null,
    };
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/authenticated',
      user: 'auth/user',
      roles: 'auth/roles',
    }),
    filteredList: function () {
      const _this = this;
      let _participants = this.participants;
      if (this.search !== '') {
        _participants = _participants.filter(
          (c) =>
            c.participant.mobile
              .replace('966', '0')
              .toLowerCase()
              .indexOf(this.search.toLowerCase()) >= 0,
        );
      }
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.participantsNew = _participants;
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.lastPage = Math.ceil(this.participantsNew.length / this.pageSize);
      if (this.lastPage == 0) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.lastPage = 1;
      }
      if (this.participantsNew.length == 0 && this.search !== '') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        _this.winners = null;
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        _this.notfound = '1';
      } else {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        _this.notfound = null;
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        _this.winners = '1';
      }
      if (_participants.length > 0) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        _this.winners = null;
      }
      return _participants.filter((row, index) => {
        const start = (this.currentPage - 1) * this.pageSize;
        const end = this.currentPage * this.pageSize;
        if (index >= start && index < end) return true;
      });
    },
  },
  watch: {
    search: function () {
      this.currentPage = 1;
    },
  },
  mounted() {
    this.fetchParticipants();
  },

  methods: {
    handleFilePondInit($id) {
      console.log($id);
      localStorage.setItem('participant', $id);
    },
    AssignParticipant($id) {
      console.log($id);
      localStorage.setItem('participant', $id);
    },
    fileError() {
      this.$toast.error('Registration is down, Please try again later');
    },
    fetchParticipants() {
      this.isLoading = true;
      const _this = this;
      axios
        .post('/api/admin/winners/pending')
        .then((result) => {
          this.isLoading = false;
          if (result.data.data.length == 0) {
            _this.winners = '1';
          } else {
            _this.winners = null;
          }
          this.participants = result.data.data;
        })
        .catch((error) => {
          this.isLoading = false;
          _this.winners = '1';
        });
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
