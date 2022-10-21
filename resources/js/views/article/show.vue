<template>
    <div class="row" v-if="article">
        <div class="col-9">
            <div class="card mb-4">
                <img class="card-img-top" :src="article.image_url" :alt="article.title" />
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">{{ article.title }}</h2>
                        <div class="small text-muted">{{ formatDate(article.created_at) }}</div>
                    </div>
                    <p class="card-text">
                        {{ article.content }}
                    </p>
                    <span class="bg-secondary p-1 px-2 rounded">
                        {{ article.category.name }}
                    </span>
                    <!-- <a class="btn btn-primary" href="#!">Read more →</a> -->
                </div>
            </div>

            <div class="row mt-3" v-if="recommendations.length > 0">
                <h4 class="text-black mb-2">Recommendation for you</h4>
                <template v-for="(article, index) in recommendations" :key="index">
                    <router-link :to="{name: 'show-articles', params: { id: article.id }}" class="col-md-6 col-12 mb-3 text-decoration-none text-black">
                        <div class="card rounded">
                            <div class="position-relative">
                                <img class="card-img-top" :src="article.image_url" :alt="article.title" style="min-height: 160px;height: 160px">
                                <div class="overlay"></div>
                            </div>
                            <div class="card-body content">
                                <div class="card-title title d-flex justify-content-between">
                                    <h5 class="text-black">{{ article.title }}</h5>
                                    <span class="text-secondary">{{ formatDate(article.created_at) }}</span>
                                </div>
                                <p class="text-base">
                                    {{ article.content }}
                                </p>
                                <span class="bg-secondary p-1 px-2 rounded">
                                    {{ article.category.name }}
                                </span>
                            </div>
                        </div>
                    </router-link>
                </template>
            </div>
        </div>

        <div class="col-3 mt-2 px-2">
            <div id="your-article">
                <h5 class="text-black">Your Article</h5>
                <template v-for="(article, index) in myArticles" :key="index">
                    <div class="card bg-transparent border-0">
                        <div class="card-body content">
                            <div class="row">
                                <div class="col-4">
                                    <img
                                        :src="article.image_url"
                                        class="img-fluid w-100 rounded"
                                        style="height: 10vh;"
                                    />
                                </div>
                                <div class="col-8 mt-2">
                                    <h5 class="text-black">
                                        {{ article.title }}
                                    </h5>
                                    <p class="text-base">
                                        {{ article.content }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div id="categories" class="mt-2">
                <h5 class="text-black">Categories</h5>
                <div class="d-flex flex-wrap">
                    <template v-for="(category, index) in categories" :key="index">
                        <span class="bg-secondary p-1 px-2 m-2 rounded">
                            {{ category.name }}
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, watch, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { Search } from '@element-plus/icons-vue'
import moment from 'moment'

export default defineComponent({
    name: 'dashboard',
    setup() {
        const route = useRoute()
        const router = useRouter()
        const categories = ref([]);

        const article = ref(null)

        const recommendations = ref([])

        const myArticles = ref([])

        const handleGetCategories = async () => {
            await axios.get("sanctum/csrf-cookie").then(async () => {
                await axios.get("/api/categories").then((response) => {
                    categories.value = response.data.data.data;
                });
            });
        };

        const handleGetArticle = async () => {
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get(`/api/articles/${route.params.id}`)
                    .then((response) => {
                        article.value = response.data.article
                        recommendations.value = response.data.recommendations
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            })
        }

        const handleGetMyArticles = async () => {
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get('/api/profile/articles')
                    .then((response) => {
                        myArticles.value = response.data.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            })
        }

        onMounted(() => {
            handleGetCategories()
            handleGetArticle()
            handleGetMyArticles()
        })

        const formatDate = (date) => {
            return moment(date).format('DD MMM YYYY')
        }

        return {
            categories,
            article,
            recommendations,
            myArticles,
            Search,
            formatDate,
        }
    }
})
</script>
