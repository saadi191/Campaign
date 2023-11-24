<template>
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <nav
      class="mb-4 sm:mb-0 sm:order-1"
      role="navigation"
      aria-label="Navigation"
    >
      <ul class="flex justify-center">
        <li class="ml-3 first:ml-0">
          <button
            class="btn bg-white border-slate-200 text-slate-500"
            :disabled="pagination.current_page === 1"
            @click="goToPreviousPage()"
          >
            &lt;- Previous
          </button>
        </li>
        <li class="ml-3 first:ml-0">
          <button
            class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500"
            @click="goToPage(pagination.current_page + 1)"
          >
            Next -&gt;
          </button>
        </li>
      </ul>
    </nav>
    <div class="text-sm text-slate-500 text-center sm:text-left">
      Showing
      <br />
      <span class="font-medium text-slate-600">{{ pagination.from }}</span>
      to
      <span class="font-medium text-slate-600">{{ pagination.to }}</span>
      of
      <span class="font-medium text-slate-600">{{ pagination.total }}</span>
      results
    </div>
  </div>
</template>

<script>
import { ChevronRightIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline';

export default {
  name: 'Pagination',
  components: {
    ChevronRightIcon,
    ChevronLeftIcon,
  },
  props: {
    pagination: { type: Object, required: true },
    offset: { type: Number, default: 4 },
  },
  computed: {
    pages() {
      if (!this.pagination.to) {
        return null;
      }
      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      const pages = [];
      for (let page = from; page <= to; page++) {
        pages.push(page);
      }
      return pages;
    },
    showPagination() {
      if (this.pages.length > 1) {
        return true;
      }
      return false;
    },
  },
  methods: {
    change(page) {
      this.$emit('paginate', page);
    },
    goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.change(page);
      }
    },
    goToPreviousPage() {
      const previousPage = this.pagination.current_page - 1;
      if (previousPage >= 1) {
        this.goToPage(previousPage);
      }
    },
  },
};
</script>
