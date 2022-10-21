<template>
    <CHeader position="sticky" class="mb-4 bg-blue-gradient">
        <CContainer fluid>
            <CHeaderToggler class="ps-1" @click="$store.commit('app/toggleSidebar')">
                <CIcon icon="cil-menu" size="lg" class="text-white" />
            </CHeaderToggler>

            <CHeaderNav class="d-none d-md-flex me-auto mx-4">
                <CNavItem>
                    <h3 class="mb-0 pb-0 text-white">Article</h3>
                    <span class="mt-0 pt-0 text-white">Explore now...</span>
                </CNavItem>
            </CHeaderNav>

            <CHeaderNav>
                <CNavItem>
                    <CNavLink href="#">
                        <span class="text-white">EN</span>
                    </CNavLink>
                </CNavItem>
                <CNavItem>
                    <CNavLink href="#">
                        <CIcon class="mx-2 text-white" icon="cil-bell" size="lg" />
                    </CNavLink>
                </CNavItem>
                <AppAccountDropdown />
            </CHeaderNav>
        </CContainer>
    </CHeader>
</template>

<script>
import AppAccountDropdown from './AppAccountDropdown.vue'
import BellIcon from '@/assets/icons/bell-icon.svg?component'
import UserIcon from '@/assets/icons/user-icon.svg?url'

export default {
    name: 'AppHeader',
    components: {
        AppAccountDropdown,
        BellIcon,
    },
    setup() {
        return {
            UserIcon
        }
    },
}
</script>
