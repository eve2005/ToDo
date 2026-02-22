<template>
  <div class=" m-auto  m-2">
    <label class=" font-paytone text-[#9F292C] flex items-center gap-3 mb-4" >
        {{ label }}
        <input :type="type" :name="name" v-model="valor"    
        class="border rounded-2xl border-[#9F292C] p-1 px-2 w-2/3 flex-1 text-black" />
    </label>
  </div>
</template>

<script setup>
    defineProps({
        label: { type: String},
        type: { type: String, default: 'text'},
        name: { type: String, default: ''}
    })
    const valor = defineModel()
</script>
