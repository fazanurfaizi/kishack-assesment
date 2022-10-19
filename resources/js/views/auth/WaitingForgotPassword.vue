<template>
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
</template>

<script>
import { defineComponent } from 'vue'
import logo from '@/assets/images/Logo-Kishack-biru.svg?url'
import clockImg from '@/assets/images/wall-clock 1.svg?url'

export default defineComponent({
    name: 'waiting-forgot-password-page',
    setup() {
        return {
            logo,
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
