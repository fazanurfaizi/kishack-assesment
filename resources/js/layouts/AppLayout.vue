<template>
    <div>
        <AppSidebar />
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <AppHeader />
            <div class="body flex-grow-1 p-5">
                <router-view />
            </div>
            <AppFooter />
        </div>
    </div>
</template>

<script>
import { CContainer } from '@coreui/vue'
import AppFooter from '@/components/AppFooter.vue'
import AppHeader from '@/components/AppHeader.vue'
import AppSidebar from '@/components/Sidebar/AppSidebar.vue'

export default {
    name: 'AppLayout',
    components: {
        AppFooter,
        AppHeader,
        AppSidebar,
        CContainer,
    },
}
</script>
