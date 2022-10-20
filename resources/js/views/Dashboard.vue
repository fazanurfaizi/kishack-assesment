<template>
    <div>
        <h1>Dashboard</h1>
        <AppFooter/>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import AppFooter from '@/components/AppFooter.vue'

export default defineComponent({
    name: 'dashboard',
    components: {
        AppFooter
    }
})
</script>
