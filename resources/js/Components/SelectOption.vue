<script setup >
import { onMounted, ref } from 'vue';

const props = defineProps({
  modelValue: {
    type: [String, Number, Object, Array],
		default: null
	},
  options: {
		type: Object,
		default: {},
	},
  string_id: {
    type: String,
    default: 'id',
  },
  string_name: {
    type: String,
    default: 'name',
  },
	model: {
		type: Boolean,
		default: false,
	},
	error_message: String,
});

defineEmits(['update:modelValue']);

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});
</script>

<template>
  <select
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    @change="$emit('update:modelValue', String($event.target.value))"
    ref="select"
  >
    <option
      v-for="(data, key) in options"
      :key="key"
      :model="model == true ? JSON.stringify(data) : ''"
      :value="String(data[string_id])"
      :selected="String(data.id) == String(modelValue)"
    >
      {{ data[string_name]}}
    </option>
  </select>
</template>
