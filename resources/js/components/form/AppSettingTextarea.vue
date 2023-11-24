<template>
  <div>
    <label class="m:w-3/12 mb-1 inline-flex w-10/12" :for="setting.key"
      >{{ setting.name }}:
    </label>
    <textarea
      :id="setting.key"
      type="text"
      :name="setting.key"
      :placeholder="setting.name"
      :disabled="disabled || loading"
      class="form-input w-full px-4 py-3 border-red-100"
      :value="setting.val"
      :rows="rows"
      :cols="cols"
      @blur="updateSetting($event.target.value)"
      @keyup.enter="$event.target.blur()"
    />
  </div>
</template>

<script lang="ts">
export default {
  name: 'AppSettingTextarea',
  props: {
    setting: { type: Object, required: true },
    loading: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    rows: { type: Number, default: 4 },
    cols: { type: Number, default: 50 },
  },
  methods: {
    updateSetting(val) {
      const { setting } = this;
      this.$emit('updateSetting', { val, setting });
    },
  },
};
</script>
