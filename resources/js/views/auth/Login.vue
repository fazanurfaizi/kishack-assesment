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
            <h3 class="text-center pb-0 text-gray" style="font-weight: bold;">Sign In</h3>
            <p class="text-center text-base text-gray">Enter your email and password to log in</p>
        </div>

        <form
            action="#"
            method="POST"
            class="row g-3 needs-validation d-flex justify-center"
            novalidate
        >
            <!-- <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                    </ul>
                </div>
            </div> -->

            <div class="col-10">
                <div class="input-group">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        v-model="form.email"
                        class="form-control p-2 bg-transparent"
                        placeholder="Email"
                        required
                    >
                </div>
            </div>

            <div class="col-10">
                <div class="input-group">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        name="password"
                        v-model="form.password"
                        class="form-control p-2 bg-transparent border-end-0 border"
                        placeholder="Password"
                        required
                    >
                    <button
                        class="input-group-text bg-transparent border-start-0 border"
                        type="button"
                        @click.prevent="showPassword = !showPassword"
                    >
                        <font-awesome-icon :icon="showPassword ? 'eye-slash' : 'eye'" />
                    </button>
                </div>
            </div>

            <div class="col-10">
                <div class="d-flex justify-content-end">
                    <router-link :to="{name: 'forgot-password'}" style="font-weight: bold;">
                        Forgot Password ?
                    </router-link>
                </div>
            </div>

            <div class="col-12 mb-5">
                <div class="d-flex justify-content-center">
                    <button
                        class="btn btn-blue-gradient btn-lg w-25"
                        type="submit"
                        @click.prevent="handleLogin()"
                        :disabled="loading"
                    >
                        <span class="text-sm">
                            {{ loading ? 'Loading...' : 'Login' }}
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { defineComponent, ref, reactive } from 'vue'
import { useStore } from 'vuex'
import logo from '@/assets/images/Logo-Kishack-biru.svg?url'
import axios from 'axios'

export default defineComponent({
    name: 'login-page',
    setup() {
        const store = useStore()

        const showPassword = ref(false)

        const form = reactive({
            email: '',
            password: ''
        })

        const loading = ref(false)

        const handleLogin = async () => {
            loading.value = true
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.post('/login', form).then((response) => {
                    console.log(response)
                    store.dispatch('auth/login')
                }).catch((error) => {
                    if(error.response.status === 422) {
                        console.log(error)
                    } else {
                        console.log('internal error')
                    }
                }).finally(() => loading.value = true)
            })
        }

        return {
            logo,
            showPassword,
            form,
            loading,
            handleLogin
        }
    }
})

</script>
