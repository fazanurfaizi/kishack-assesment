<template>
    <component :is="type" v-bind="linkProps(to)">
        <slot />
    </component>
</template>

<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
    name: 'link',
    props: {
        to: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const isExternal = computed(() => /^(https?:|mailto:|tel:)/.test(props.to))

        const type = () => {
            if(isExternal.value) {
                return 'a'
            }

            return 'router-link'
        }

        const linkProps = (to) => {
            if(isExternal.value) {
                return {
                    href: to,
                    target: '_blank',
                    rel: 'noopener'
                }
            }

            return {
                to: to
            }
        }

        return {
            type,
            linkProps
        }
    }
})
</script>
