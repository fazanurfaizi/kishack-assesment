<template>
    <div v-if="!item.hidden">
        <template v-if="hasOneShowingChild(item.children,item) && (!onlyOneChild.children||onlyOneChild.noShowingChildren) && !item.alwaysShow">
            <app-link v-if="onlyOneChild.meta" :to="resolvePath(onlyOneChild.path)">
                <el-menu-item :index="resolvePath(onlyOneChild.path)" :class="{'submenu-title-noDropdown': !isNested}">
                    <item :icon="onlyOneChild.meta.icon||(item.meta&&item.meta.icon)" :title="onlyOneChild.meta.title" />
                </el-menu-item>
            </app-link>
        </template>

        <el-submenu v-else :ref="subMenu" :index="resolvePath(item.path)" popper-append-to-body>
            <template slot="title">
                <item v-if="item.meta" :icon="item.meta && item.meta.icon" :title="item.meta.title" />
            </template>

            <sidebar-item
                v-for="child in item.children"
                :key="child.path"
                :is-nest="true"
                :item="child"
                :base-path="resolvePath(child.path)"
                class="nest-menu"
            />
        </el-submenu>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, computed } from 'vue'
import { useStore } from 'vuex'
import path from 'path'
import Item from './Item.vue'
import AppLink from './Link.vue'

export default defineComponent({
    name: 'sidebar-item',
    components: {
        Item,
        AppLink
    },
    props: {
        item: {
            type: Object,
            required: true
        },
        isNested: {
            type: Boolean,
            required: false
        },
        basePath: {
            type: String,
            default: ''
        }
    },
    setup(props) {

        const store = useStore()

        const device = computed(() => store.getters['app/device'])

        const subMenu = ref(null)

        const onlyOneChild = ref(null)

        // const isExternal = computed(() => /^(https?:|mailto:|tel:)/.test(props.to))
        const hasOneShowingChild = (children = [], parent) => {
            const showingChildren = children.filter(item => {
                if(item.hidden) {
                    return false
                } else {
                    onlyOneChild.value = item
                    return true
                }
            })

            if(showingChildren.length === 1) {
                return true
            }

            if(showingChildren.length === 0) {
                onlyOneChild = {
                    ...parent,
                    path: '',
                    noShowingChildren: true
                }
                return true
            }

            return false
        }

        const isExternal = (path) => {
            return /^(https?:|mailto:|tel:)/.test(path)
        }

        const resolvePath = (routePath) => {
            if(isExternal(routePath)) {
                return routePath
            }

            if(isExternal(props.basePath)) {
                return props.basePath
            }

            return path.resolve(props.basePath, routePath)
        }

        const fixingResize = () => {
            if(subMenu.value) {
                const handleMouseLeave = subMenu.value?.handleMouseLeave
                subMenu.handleMouseLeave = (e) => {
                    if(device.value === 'mobile') {
                        return
                    }
                    handleMouseLeave(e)
                }
            }
        }

        onMounted(() => {
            fixingResize()
        })

        return {
            hasOneShowingChild,
            resolvePath,
            onlyOneChild,
            subMenu
        }
    }
})
</script>
