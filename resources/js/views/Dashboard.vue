<template>
    <div>
        <h1>Dashboard</h1>
        <AppFooter/>
    </div>
</template>

<script>
import { defineComponent, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import AppFooter from '@/components/AppFooter.vue'

export default defineComponent({
    name: 'dashboard',
    components: {
        AppFooter
    },
    setup() {
        const store = useStore()

        const categories = computed(() => store.getters['category/categories'])

        onMounted(() => {
            store.dispatch('category/allCategories')
        })

        return {
            categories
        }
    }
})
</script>
