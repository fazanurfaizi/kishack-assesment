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
            <p class="text-center text-base text-gray">Input your new password</p>
        </div>

        <form class="row g-3 needs-validation d-flex justify-center" novalidate>
            <div class="col-10">
                <div class="input-group has-validation">
                    <input
                        type="password"
                        name="password"
                        class="form-control p-2 bg-transparent border-end-0 border"
                        id="password"
                        placeholder="New Password"
                        required
                    >
                    <div class="invalid-feedback">Please enter your password.</div>
                    <button class="input-group-text bg-transparent border-start-0 border">
                        <span class="px-1" id="inputGroupApend">@</span>
                    </button>
                </div>
            </div>

            <div class="col-10">
                <div class="input-group has-validation">
                    <input
                        type="password"
                        name="password"
                        class="form-control p-2 bg-transparent border-end-0 border"
                        id="password"
                        placeholder="Re Enter Password"
                        required
                    >
                    <div class="invalid-feedback">Please enter your password.</div>
                    <button class="input-group-text bg-transparent border-start-0 border">
                        <span class="px-1" id="inputGroupApend">@</span>
                    </button>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-blue-gradient btn-lg w-25" type="submit">
                        <span class="text-sm">
                            Save
                        </span>
                    </button>
                </div>
            </div>

            <div class="col-10 mt-4">
                <div class="d-flex justify-content-center">
                    <span class="text-gray">
                        Do you already have an account ?
                    </span>
                    <router-link :to="{name: 'login'}" class="ml-1" style="font-weight: bold;">
                        Login
                    </router-link>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import logo from '@/assets/images/Logo-Kishack-biru.svg?url'

export default defineComponent({
    name: 'reset-password-page',
    setup() {
        return {
            logo
        }
    }
})

</script>
