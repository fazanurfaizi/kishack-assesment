<template>
    <div id="background" :style="{backgroundImage: `url(${background})`}">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card w-100 mb-3">
                            <div class="card-body p-4">
                                <div class="logo d-flex align-items-center w-auto">
                                    <img :src="logo" alt="Kishack" class="img-fluid mx-auto" style="width: 30%;">
                                </div>
                                <div class="d-flex align-items-center w-auto">
                                    <span class="mx-auto text-primary small text-small whitespace-nowrap">
                                        PT. KARYA INOVASI SUKSES
                                    </span>
                                </div>

                                <div class="mt-5 mb-5">
                                    <h3 class="text-center pb-0 text-gray" style="font-weight: bold;">Forgot Password</h3>
                                    <p class="text-center text-base text-gray">Waiting for verification</p>
                                </div>

                                <div class="row g-3 needs-validation d-flex justify-center">
                                    <img :src="clockImg" alt="Success" class="img-fluid h-10 w-25">

                                    <div class="col-10 my-5">
                                        <div class="d-flex justify-content-center">
                                            <span class="text-gray">
                                                We have sent a message link for you,
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <span class="text-gray">
                                                please check your email.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
import clockImg from '@/assets/images/wall-clock 1.svg?url'

export default defineComponent({
    name: 'waiting-forgot-password-page',
    setup() {
        return {
            logo,
            background,
            clockImg
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
