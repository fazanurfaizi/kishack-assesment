<template>
    <CSidebar
        position="fixed"
        :unfoldable="sidebarUnfoldable"
        :visible="sidebarVisible"
        @visible-change="
            (event) =>
            $store.commit({
                type: 'app/updateSidebarVisible',
                value: event,
            })
        "
    >
        <CSidebarBrand>
            <div class="text-center">
                <Logo class="mx-auto" />
                <span class="mx-auto text-primary" style="font-size: xx-small;">
                    PT. KARYA INOVASI SUKSES
                </span>
            </div>
        </CSidebarBrand>

        <AppSidebarItem />
    </CSidebar>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { AppSidebarItem } from './AppSidebarItem'
import { logoNegative } from '@/assets/brand/logo-negative'
import { sygnet } from '@/assets/brand/sygnet'
import Logo from '@/assets/images/Logo-Kishack-biru.svg?component'

export default {
    name: 'AppSidebar',
    components: {
        AppSidebarItem,
        Logo
    },
    setup() {
        const store = useStore()
        return {
            logoNegative,
            sygnet,
            sidebarUnfoldable: computed(() => store.state.app.sidebarUnfoldable),
            sidebarVisible: computed(() => store.state.app.sidebarVisible),
        }
    },
}
</script>
