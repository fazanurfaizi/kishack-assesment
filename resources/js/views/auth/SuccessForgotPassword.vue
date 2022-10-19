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
            <h3 class="text-center pb-0 text-gray" style="font-weight: bold;">Success</h3>
        </div>

        <div class="row g-3 needs-validation d-flex justify-center">
            <img :src="checkImg" alt="Success" class="img-fluid h-10 w-25">

            <div class="col-10 my-5">
                <div class="d-flex justify-content-center">
                    <span class="text-gray">
                        Yeah! You have successfully changed your password,
                    </span>
                </div>
                <div class="d-flex justify-content-center">
                    <span class="text-gray">
                        please sign in back
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import logo from '@/assets/images/Logo-Kishack-biru.svg?url'
import checkImg from '@/assets/images/checklist.svg?url'

export default defineComponent({
    name: 'waiting-forgot-password-page',
    setup() {
        return {
            logo,
            checkImg
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
