<template>
    <div id="background" :style="{backgroundImage: `url(${background})`}">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card w-100 mb-3">
                            <router-view></router-view>
                        </div>

                        <div class="credits mt-5">
                            <span class="text-white">v0.0.1 &#169; 2022</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import logo from '@/assets/images/Logo-Kishack-biru.svg?url'
import background from '@/assets/images/auth-bg.svg?url'

export default defineComponent({
    name: 'login-page',
    setup() {
        return {
            logo,
            background
        }
    }
})

</script>

<style scoped>
div #background {
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
}
</style>
