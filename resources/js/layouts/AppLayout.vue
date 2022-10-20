<template>
    <div :class="classObj" class="app-wrapper">
        <div v-if="device==='mobile' && sidebar.opened" class="drawer-bg" @click="handleClickOutside" />
        <sidebar class="sidebar-container" />
        <div class="main-container">
            <div class="fixed-header">
                <navbar />
            </div>
            <app-main />
        </div>
    </div>
</template>

<script>
import { defineComponent, computed, watch, onBeforeMount, onBeforeUnmount, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import Navbar from '@/components/Navbar.vue'
import Sidebar from '@/components/Sidebar/index.vue'
import AppMain from '@/components/AppMain.vue'

const { body } = document
const WIDTH = 992

export default defineComponent({
    name: 'app-layout',
    components: {
        Navbar,
        Sidebar,
        AppMain
    },
    setup() {
        const store = useStore()

        const route = useRoute()

        const sidebar = computed(() => store.getters['app/sidebar'])

        const device = computed(() => store.getters['app/device'])

        const classObj = computed(() => {
            return {
                hideSidebar: !sidebar.value.opened,
                openSidebar: sidebar.value.opened,
                withoutAnimation: sidebar.value.withoutAnimation,
                mobile: device.value === 'mobile'
            }
        })

        const handleClickOutside = () => {
            store.dispatch('app/closeSidebar', { withoutAnimation: false })
        }

        const isMobile = () => {
            const rect = document.body.getBoundingClientRect()
            return rect.widht - 1 < WIDTH
        }

        const resizeHandler = () => {
            if(!document.hidden) {
                const isMobile = isMobile()
                store.dispatch('app/toggleDevice', isMobile ? 'mobile' : 'desktop')

                if(isMobile) {
                    store.dispatch('app/closeSideBar', { withoutAnimation: true })
                }
            }
        }

        watch(route, () => {
            if(device.value === 'mobile' && sidebar.value.opened) {
                store.dispatch('app/closeSidebar', { withoutAnimation: false })
            }
        })

        onBeforeMount(() => {
            window.addEventListener('resize', resizeHandler)
        })

        onBeforeUnmount(() => {
            window.removeEventListener('resize', resizeHandler)
        })

        onMounted(() => {
            const isMobile = isMobile()
            if(isMobile) {
                store.dispatch('app/toggleDevice', 'mobile')
                store.dispatch('app/closeSidebar', { withoutAnimation: true })
            }
        })

        return {
            classObj,
            handleClickOutside
        }
    }
})
</script>
