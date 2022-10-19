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
                                    <p class="text-center text-base text-gray">Enter your email and captcha to reset your password</p>
                                </div>

                                <form class="row g-3 needs-validation d-flex justify-center" novalidate>
                                    <div class="col-10">
                                        <div class="input-group has-validation">
                                            <input type="email" name="email" class="form-control p-2 bg-transparent" id="email" placeholder="Email" required>
                                            <div class="invalid-feedback">Please enter your email.</div>
                                        </div>
                                    </div>

                                    <div class="col-10">
                                        <div class="d-flex justify-content-center">
                                            <vue-recaptcha sitekey="6LdRjpIiAAAAAK6qDgrZSTLzhtvJ8XnqlzpQgyie"></vue-recaptcha>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-blue-gradient btn-lg w-25" type="submit">
                                                <span class="text-sm">
                                                    Verification
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-10 mt-4">
                                        <div class="d-flex justify-content-center">
                                            <span class="text-gray">
                                                Do you already have an account ?
                                            </span>
                                            <router-link :to="{name: 'dashboard'}" class="ml-1" style="font-weight: bold;">
                                                Login
                                            </router-link>
                                        </div>
                                    </div>
                                </form>
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
import { VueRecaptcha } from 'vue-recaptcha';

export default defineComponent({
    name: 'forgot-password-page',
    components: {
        VueRecaptcha
    },
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
