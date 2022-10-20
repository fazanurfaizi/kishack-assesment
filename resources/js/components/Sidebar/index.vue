<template>
    <div class="has-logo">
        <logo :collapse="isCollapse" />
        <el-scrollbar wrap-class="scrollbar-wrapper">
            <el-menu
                :default-active="activeMenu"
                :collapse="isCollapse"
                background-color="#304156"
                text-color="#bfcbd9"
                :unique-opened="false"
                active-text-color="#409EFF"
                :collapse-transition="false"
                mode="vertical"
            />
            <sidebar-item v-for="route in routes" :key="route.path" :item="route" :base-path="route.path" />
        </el-scrollbar>
    </div>
</template>

<script>
import { defineComponent, computed } from 'vue'
import { useStore } from 'vuex'
import { useRoute, useRouter } from 'vue-router'
import SidebarItem from './SidebarItem.vue'
import Logo from './Logo.vue'

export default defineComponent({
    name: 'sidebar',
    components: {
        SidebarItem,
        Logo
    },
    setup() {
        const store = useStore()
        const route = useRoute()
        const router = useRouter()

        const sidebar = computed(() => store.getters['app/sidebar'])

        const routes = computed(() => router.options.routes)

        const activeMenu = computed(() => {
            const { meta, path } = route

            if(meta.activeMenu) {
                return meta.activeMenu
            }

            return path
        })

        const isCollapse = computed(() => !sidebar.value.opened)

        return {
            routes,
            activeMenu,
            isCollapse
        }
    }
})
</script>
