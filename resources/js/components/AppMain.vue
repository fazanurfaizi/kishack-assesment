<template>
    <section class="app-main">
        <transition name="fade-transform" mode="out-in">
            <router-view :key="key" />
        </transition>
    </section>
</template>

<script>
import { computed, defineComponent } from 'vue'
import { useRoute } from 'vue-router'

export default defineComponent({
    name: 'app-main',
    setup() {
        const route = useRoute()

        const key = computed(() => route.path)

        return {
            key
        }
    }
})
</script>

<style scoped>
.app-main {
    /*50 = navbar  */
    min-height: calc(100vh - 50px);
    width: 100%;
    position: relative;
    overflow: hidden;
}
.fixed-header+.app-main {
    padding-top: 50px;
}
</style>

<style lang="scss">
// fix css style bug in open el-dialog
.el-popup-parent--hidden {
    .fixed-header {
        padding-right: 15px;
    }
}
</style>
