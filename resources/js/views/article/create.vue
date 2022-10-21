<template>
    <form>
        <div class="form row mt-4">
            <ImageUpload @change="handleImage" />
        </div>

        <div class="form row mt-4">
            <div class="form-group col-sm">
                <label for="title">Title Article</label>
                <input type="text" class="form-control" id="title" placeholder="Input your title" v-model="form.title" />
            </div>
        </div>

        <div class="form col mt-4">
            <div class="form-group">
                <label for="articleBody">Content</label>
                <textarea id="articleBody" class="form-control" rows="20" cols="150" placeholder="Input your description" v-model="form.content"></textarea>
            </div>
        </div>

        <div class="form col mt-4">
            <div class="form-group">
                <label for="articleBody">Categories</label>
                <select id="categories" name="category" class="form-control" v-model="form.category_id">
                    <option value="" disabled selected>Select Category</option>
                    <option v-for="(category, index) in categories" :value="category.id" :key="index">
                        {{ category.name }}
                    </option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <router-link :to="{name: 'list-articles'}" class="btn btn-secondary text-white px-5">
                Cancel
            </router-link>

            <button name="submitbtn" class="btn btn-blue-gradient px-5" @click.prevent="handlePost()">
                Save
            </button>
        </div>

    </form>
</template>

<script>
import axios from 'axios'
import { useRouter } from 'vue-router'
import { reactive, ref, onMounted } from 'vue'
import ImageUpload from '../../components/ImageUpload.vue'

export default {
    name: "create-articles",
    component: {
        ImageUpload
    },
    setup() {
        const router = useRouter();
        const form = reactive({
            title: "",
            content: "",
            image: null,
            category_id: ""
        });
        const categories = ref([]);
        const handleGetCategories = async () => {
            await axios.get("sanctum/csrf-cookie").then(async () => {
                await axios.get("/api/categories").then((response) => {
                    categories.value = response.data.data.data;
                });
            });
        };
        const handleImage = (file) => {
            form.image = file[0];
        };
        const handlePost = async () => {
            const formData = new FormData();
            formData.append("title", form.title);
            formData.append("content", form.content);
            formData.append("category_id", form.category_id);
            formData.append("image", form.image);
            await axios.get("sanctum/csrf-cookie").then(async () => {
                await axios.post("/api/articles", formData)
                    .then((response) => {
                    ElMessage({
                        showClose: true,
                        message: "Article created successfully",
                        type: "success",
                    });
                })
                    .catch((error) => {
                    console.log(error);
                })
                    .finally(() => router.push({ name: "list-articles" }));
            });
        };
        onMounted(() => {
            handleGetCategories();
        });
        return {
            form,
            categories,
            handleImage,
            handlePost
        };
    },
    components: { ImageUpload }
}

</script>
