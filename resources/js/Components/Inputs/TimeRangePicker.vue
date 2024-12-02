<script setup>
import { defineProps, defineEmits, ref, watch, computed } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => [{
      start: '',
      end: ''
    }]
  }
})

const emit = defineEmits(['update:modelValue'])

const timeRanges = ref(props.modelValue.map(range => ({
  start: range.start ? new Date(`2000-01-01T${range.start}:00`) : null,
  end: range.end ? new Date(`2000-01-01T${range.end}:00`) : null,
  isStartSelected: !!range.start,
  isEndSelected: !!range.end
})))

const formatTime = (timeObj) => {
  if (!timeObj) return ''
  
  // If it's a Date object
  if (timeObj instanceof Date) {
    const hours = timeObj.getHours().toString().padStart(2, '0')
    const minutes = timeObj.getMinutes().toString().padStart(2, '0')
    return `${hours}:${minutes}`
  }
  
  // If it's a time picker object
  if (typeof timeObj === 'object' && timeObj !== null) {
    const hours = (timeObj.hours ?? 0).toString().padStart(2, '0')
    const minutes = (timeObj.minutes ?? 0).toString().padStart(2, '0')
    return `${hours}:${minutes}`
  }
  
  return ''
}

const updateTime = (index, type, value) => {
  // Handle both Date object and time picker object
  const processedTime = value instanceof Date 
    ? value 
    : new Date(`2000-01-01T${formatTime(value)}:00`)
  
  timeRanges.value[index][type] = processedTime
  timeRanges.value[index][`is${type.charAt(0).toUpperCase() + type.slice(1)}Selected`] = true
  
  // Validate time range
  if (timeRanges.value[index].start && timeRanges.value[index].end) {
    const startTime = timeRanges.value[index].start.getTime()
    const endTime = timeRanges.value[index].end.getTime()
    
    if (endTime <= startTime) {
      return
    }
  }
  
  emitUpdate()
}

const emitUpdate = () => {
  const newRanges = timeRanges.value.map(range => ({
    start: formatTime(range.start),
    end: formatTime(range.end)
  }))
  
  emit('update:modelValue', newRanges)
}

const addTimeRange = () => {
  timeRanges.value.push({ 
    start: null, 
    end: null, 
    isStartSelected: false, 
    isEndSelected: false 
  })
  
  emitUpdate()
}

const removeTimeRange = (index) => {
  if (timeRanges.value.length <= 1) {
    timeRanges.value = [{ 
      start: null, 
      end: null, 
      isStartSelected: false, 
      isEndSelected: false 
    }]
    emit('update:modelValue', [{ start: '', end: '' }])
    return
  }
  
  timeRanges.value.splice(index, 1)
  emitUpdate()
}

const generateTimeOptions = () => {
  const options = []
  for (let hour = 0; hour < 24; hour++) {
    for (let minute = 0; minute < 60; minute += 30) {
      const timeObj = {
        hours: hour,
        minutes: minute
      }
      options.push(timeObj)
    }
  }
  return options
}

const timeOptions = generateTimeOptions()
</script>

<template>
  <div class="space-y-2">
    <div 
      v-for="(range, index) in timeRanges" 
      :key="index" 
      class="flex items-center space-x-2"
    >
      <VueDatePicker
        model="range.start"
        time-picker
        :time-format="'HH:mm'"
        :min-time="{ hours: 0, minutes: 0 }"
        :max-time="{ hours: 23, minutes: 59 }"
        text-input
        :only-time="true"
        :auto-apply="true"
        @update:model-value="(val) => updateTime(index, 'start', val)"
        class="w-32"
        :enable-seconds="false"
        :placeholder="range.start ? formatTime(range.start) : 'Pilih Jam'"
        :dark="true"
        :disabled="index > 0 && !timeRanges[index-1].end"
        :time-picker-inline="true"
        :time-options="timeOptions"
        select-text="Pilih"
        cancel-text="Batal"
      />
      
      <span class="text-dark-text">sampai</span>
      
      <VueDatePicker
        model="range.end"
        time-picker
        :time-format="'HH:mm'"
        :min-time="range.start ? { 
          hours: range.start.getHours(), 
          minutes: range.start.getMinutes()
        } : { hours: 0, minutes: 0 }"
        :max-time="{ hours: 23, minutes: 59 }"
        text-input
        :only-time="true"
        :auto-apply="true"
        @update:model-value="(val) => updateTime(index, 'end', val)"
        class="w-32"
        :enable-seconds="false"
        :placeholder="range.end ? formatTime(range.end) : 'Pilih Jam'"
        :dark="true"
        :disabled="!range.start"
        :time-picker-inline="true"
        :time-options="timeOptions"
        select-text="Pilih"
        cancel-text="Batal"
      />
      
      <button 
        v-if="timeRanges.length > 1"
        @click="removeTimeRange(index)"
        type="button"
        class="p-1 text-white hover:text-gray-200"
        aria-label="Remove time range"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
    
    <button 
      @click="addTimeRange"
      type="button"
      class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-dark-accent hover:bg-dark-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-accent"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
      </svg>
      Add Time
    </button>
  </div>
</template>

<style>
/* Memperbesar ukuran time picker */
.dp__time_picker {
  padding: 1rem !important;
  min-width: 150px !important;
}

.dp__time_col {
  /* width: 150px !important; */
  padding: 0.5rem !important;
}

.dp__time_select {
  height: 200px !important;
}

.dp__time_picker_item {
  padding: 0.75rem 1rem !important;
  font-size: 1rem !important;
}
/* Memperbesar tampilan waktu yang dipilih */
.dp__time_display {
  font-size: 3rem !important;
  padding: 0.75rem !important;
  margin-bottom: 0.5rem !important;
}

/* Memperbesar scrollbar */
.dp__time_select::-webkit-scrollbar {
  width: 10px !important;
}

.dp__time_select::-webkit-scrollbar-track {
  background: var(--dp-border-color) !important;
  border-radius: 5px !important;
}

.dp__time_select::-webkit-scrollbar-thumb {
  background: var(--dp-primary-color) !important;
  border-radius: 5px !important;
}

.dp__time_select::-webkit-scrollbar-thumb:hover {
  background: var(--dp-hover-color) !important;
}
</style>