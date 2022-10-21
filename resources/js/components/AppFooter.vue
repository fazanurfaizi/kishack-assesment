<template>
    <CFooter class="mx-5">
        <div class="d-flex justify-content-between">
            <span class="ms-1">&copy; <b>{{ new Date().getFullYear() }}</b> Copyright Mitra Hino</span>
        </div>
        <Metamine />
    </CFooter>
</template>

<script>
import Metamine from '@/assets/images/metamine.svg?component'

export default {
    name: 'AppFooter',
    components: {
        Metamine
    }
}
</script>
