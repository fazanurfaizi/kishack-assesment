<template>
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-md-7 col-12">
                    <el-input
                        v-model="searchQuery"
                        placeholder="Search article..."
                        :suffix-icon="Search"
                        size="large"
                    />
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-control py-2 block" v-model="category" @change="handleChangeCategory">
                        <option value="" disabled selected>Categories</option>
                        <option v-for="(category, index) in categories" :value="category.id" :key="index">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <button @click="createArticle" class="col-md-2 col-6 btn btn-blue-gradient d-flex py-2">
                    Create Article
                    <svg style="width: 20px;" class="ml-2 d-none d-md-block" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" data-v-029747aa=""><path d="m199.04 672.64 193.984 112 224-387.968-193.92-112-224 388.032zm-23.872 60.16 32.896 148.288 144.896-45.696L175.168 732.8zM455.04 229.248l193.92 112 56.704-98.112-193.984-112-56.64 98.112zM104.32 708.8l384-665.024 304.768 175.936L409.152 884.8h.064l-248.448 78.336L104.32 708.8zm384 254.272v-64h448v64h-448z" fill="currentColor"></path></svg>
                </button>
            </div>

            <div class="row mt-3">
                <template v-for="(article, index) in articles" :key="index">
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

                <div class="d-flex justify-content-center">
                    <router-link :to="{name: 'list-articles'}" class="btn-link">
                        Show all...
                    </router-link>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 mt-2 px-2">
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
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { Search } from '@element-plus/icons-vue'
import { debounce } from '@/utils/index.js'
import moment from 'moment'

export default defineComponent({
    name: 'dashboard',
    setup() {
        const store = useStore()
        const router = useRouter()
        const categories = ref([]);

        const articles = ref([])

        const category = ref('')

        const myArticles = ref([])

        const handleGetCategories = async () => {
            await axios.get("sanctum/csrf-cookie").then(async () => {
                await axios.get("/api/categories").then((response) => {
                    categories.value = response.data.data.data;
                });
            });
        };

        const searchQuery = ref('')

        const handleGetArticles = async () => {
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get('/api/articles', {
                    params: {
                        search: searchQuery.value,
                        limit: 10,
                        page: 1,
                        category_id: category.value
                    }
                })
                    .then((response) => {
                        articles.value = response.data.data.data
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

        const createArticle = () => {
            router.push({
                name: 'create-articles'
            })
        }

        const handleChangeCategory = () => {
            handleGetArticles()
        }

        onMounted(() => {
            store.commit('app/setBreadcrumb', {
                title: 'Article',
                subtitle: 'Explore now...'
            })

            handleGetCategories()
            handleGetArticles()
            handleGetMyArticles()
        })

        watch(searchQuery, (value) => {
            searchQuery.value = value
            let returnedFunction = debounce(function() {
                handleGetArticles()
            }, 250);

            returnedFunction()
        })

        const formatDate = (date) => {
            return moment(date).format('DD MMM YYYY')
        }

        return {
            categories,
            searchQuery,
            articles,
            myArticles,
            category,
            createArticle,
            Search,
            formatDate,
            handleChangeCategory
        }
    }
})
</script>
