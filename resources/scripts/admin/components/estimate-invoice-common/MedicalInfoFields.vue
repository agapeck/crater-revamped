<template>
  <div class="mb-6">
    <label class="text-gray-800 font-medium mb-4 text-sm">
      {{ $t('customers.medical_info') }}
    </label>
    
    <BaseInputGrid class="mt-4">
      <BaseInputGroup 
        :label="$t('customers.age')"
        :error="v$.customer.age.$error && v$.customer.age.$errors[0].$message"
      >
        <BaseInput
          v-model="store[storeProp].customer.age"
          type="number"
          :content-loading="isLoading"
          :invalid="v$.customer.age.$error"
          min="0"
          max="150"
          @input="v$.customer.age.$touch()"
        />
      </BaseInputGroup>

      <BaseInputGroup 
        :label="$t('customers.next_of_kin')"
        :error="v$.customer.next_of_kin.$error && v$.customer.next_of_kin.$errors[0].$message"
      >
        <BaseInput
          v-model="store[storeProp].customer.next_of_kin"
          type="text"
          :content-loading="isLoading"
          :invalid="v$.customer.next_of_kin.$error"
          @input="v$.customer.next_of_kin.$touch()"
        />
      </BaseInputGroup>

      <BaseInputGroup 
        :label="$t('customers.next_of_kin_phone')"
        :error="v$.customer.next_of_kin_phone.$error && v$.customer.next_of_kin_phone.$errors[0].$message"
      >
        <BaseInput
          v-model="store[storeProp].customer.next_of_kin_phone"
          type="text"
          :content-loading="isLoading"
          :invalid="v$.customer.next_of_kin_phone.$error"
          @input="v$.customer.next_of_kin_phone.$touch()"
        />
      </BaseInputGroup>

      <BaseInputGroup 
        :label="$t('customers.diagnosis')"
        :error="v$.customer.diagnosis.$error && v$.customer.diagnosis.$errors[0].$message"
      >
        <BaseInput
          v-model="store[storeProp].customer.diagnosis"
          type="text"
          :content-loading="isLoading"
          :invalid="v$.customer.diagnosis.$error"
          @input="v$.customer.diagnosis.$touch()"
        />
      </BaseInputGroup>

      <BaseInputGroup 
        :label="$t('customers.treatment')"
        :error="v$.customer.treatment.$error && v$.customer.treatment.$errors[0].$message"
      >
        <BaseInput
          v-model="store[storeProp].customer.treatment"
          type="text"
          :content-loading="isLoading"
          :invalid="v$.customer.treatment.$error"
          @input="v$.customer.treatment.$touch()"
        />
      </BaseInputGroup>

      <BaseInputGroup 
        :label="$t('customers.attended_by')"
        :error="v$.customer.attended_by.$error && v$.customer.attended_by.$errors[0].$message"
      >
        <BaseInput
          v-model="store[storeProp].customer.attended_by"
          type="text"
          :content-loading="isLoading"
          :invalid="v$.customer.attended_by.$error"
          @input="v$.customer.attended_by.$touch()"
        />
      </BaseInputGroup>

      <BaseInputGroup 
        :label="$t('customers.review_date')"
        :error="v$.customer.review_date.$error && v$.customer.review_date.$errors[0].$message"
      >
        <BaseDatePicker
          v-model="store[storeProp].customer.review_date"
          :content-loading="isLoading"
          :calendar-button="true"
          calendar-button-icon="calendar"
          :invalid="v$.customer.review_date.$error"
          :min-date="new Date()"
          @input="v$.customer.review_date.$touch()"
        />
      </BaseInputGroup>
    </BaseInputGrid>
  </div>
</template>

<script setup>
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength, helpers, minValue, maxValue, regex } from '@vuelidate/validators'
import { computed } from 'vue'

const props = defineProps({
  store: {
    type: Object,
    required: true
  },
  storeProp: {
    type: String,
    required: true
  },
  isLoading: {
    type: Boolean,
    default: false
  }
})

const rules = computed(() => ({
  customer: {
    age: { 
      integer: helpers.withMessage('Age must be a whole number', Number.isInteger),
      minValue: helpers.withMessage('Age cannot be negative', minValue(0)),
      maxValue: helpers.withMessage('Age cannot exceed 150 years', maxValue(150))
    },
    next_of_kin: { 
      maxLength: helpers.withMessage('Next of kin name cannot exceed 255 characters', maxLength(255))
    },
    next_of_kin_phone: {
      maxLength: helpers.withMessage('Next of kin phone number cannot exceed 255 characters', maxLength(255)),
      regex: helpers.withMessage(
        'Next of kin phone number format is invalid',
        regex(/^([0-9\s\-\+\(\)]*)$/)
      )
    },
    attended_by: {
      maxLength: helpers.withMessage('Attended by field cannot exceed 255 characters', maxLength(255))
    },
    review_date: {
      minDate: helpers.withMessage(
        'Review date must be today or a future date',
        (value) => !value || new Date(value) >= new Date().setHours(0, 0, 0, 0)
      )
    }
  }
}))

const v$ = useVuelidate(
  rules,
  computed(() => props.store[props.storeProp])
)
</script> 