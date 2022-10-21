<template>
    <div>
        <div class="row mb-3">
            <div class="col-7">
                <el-button
                    v-if="multipleSelection.length > 0"
                    :icon="Delete"
                    circle
                    class="mx-2 text-danger bg-transparent border-0"
                    @click="handleDelete"
                />

                <el-input
                    v-model="searchQuery"
                    placeholder="Search"
                    :suffix-icon="Search"
                    style="width: 30%;"
                />

                <el-button :icon="Refresh" circle class="mx-2 text-primary bg-transparent border-0" />
            </div>
            <div class="col-5 d-flex justify-content-end">
                <button
                    class="btn btn-blue-gradient w-25"
                    type="button"
                    @click="createArticle"
                >
                    <span class="text-sm">
                        + Add New
                    </span>
                </button>
            </div>
        </div>

        <el-table
            :data="tableData"
            :default-sort="{ prop: 'date', order: 'descending' }"
            ref="multipleTableRef"
            style="width: 100%"
            @selection-change="handleSelectionChange"
            stripe
            table-layout="fixed"
        >
            <el-table-column type="selection" width="100" />
            <el-table-column label="Actions">
                <template #default="scope">
                    <el-button
                        type="primary"
                        size="small"
                        @click="editArticle(scope.row)"
                        :icon="EditPen"
                    />
                    <el-button
                        type="primary"
                        size="small"
                        @click="detailArticle(scope.row)"
                        :icon="View"
                    />
                </template>
            </el-table-column>
            <el-table-column prop="title" label="Title Article" sortable />
            <el-table-column prop="cateogry" label="Categories" sortable>
                <template #default="scope">
                    <span>
                        {{ scope.row.category.name }}
                    </span>
                </template>
            </el-table-column>
        </el-table>

        <div class="d-flex justify-content-between">
            <el-pagination
                background
                layout="prev, pager, next"
                v-model:currentPage="currentPage"
                v-model:page-size="pageSize"
                :page-sizes="[5, 10, 25, 50]"
                :total="totalData"
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
            />
            <div class="px-2">
                <el-select
                    v-model="pageSize"
                    class="m-2"
                    placeholder="Select"
                    size="large"
                    @change="handleSizeChange"
                    style="width: 75px;"
                >
                    <el-option
                        v-for="item in pageOptions"
                        :key="item"
                        :label="item"
                        :value="item"
                    />
                </el-select>
                <span class="text-gray">Showing {{`${meta.from}-${meta.to}`}} of {{ pageSize }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { ElMessage } from 'element-plus'
import { Search, Refresh, EditPen, View, Delete } from '@element-plus/icons-vue'
import axios from 'axios'
import { debounce, formatDate } from '@/utils/index.js'

export default {
    name: 'articles',
    setup() {
        const store = useStore()

        const router = useRouter()

        const loading = ref(false)

        const tableData = ref([])

        const detailData = ref(null)

        const totalData = ref(0)

        const meta = ref({
            from: 0,
            to: 0
        })

        const multipleTableRef = ref(null)

        const multipleSelection = ref([])

        const toggleSelection = (rows) => {
            if (rows) {
                rows.forEach((row) => {
                    multipleTableRef.value.toggleRowSelection(row, undefined)
                })
            } else {
                multipleTableRef.value.clearSelection()
            }
        }

        const handleSelectionChange = (val) => {
            multipleSelection.value = val
        }

        const searchQuery = ref('')

        const currentPage = ref(1)

        const pageSize = ref(5)

        const pageOptions = [5, 10, 25, 50]

        const handleSizeChange = (val) => {
            pageSize.value = val
            handleGetArticles()
        }

        const handleCurrentChange = (val) => {
            currentPage.value = val
            handleGetArticles()
        }

        const handleGetArticles = async () => {
            loading.value = true
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get('/api/articles', {
                    params: {
                        search: searchQuery.value,
                        limit: pageSize.value,
                        page: currentPage.value
                    }
                })
                    .then((response) => {
                        tableData.value = response.data.data.data
                        totalData.value = response.data.data.total
                        meta.value.from = response.data.data.from ?? 0
                        meta.value.to = response.data.data.to ?? 0
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => {
                        loading.value = false
                    })
            })
        }

        const createArticle = () => {
            router.push({ name: 'create-articles' })
        }

        const editArticle = (row) => {
            router.push({ name: 'edit-articles', params: { id: row.id } })
        }

        const detailArticle = (row) => {
            router.push({ name: 'show-articles', params: { id: row.id } })
        }

        const handleDelete = async () => {
            loading.value = true
            const ids = multipleSelection.value.map((value) => value.id)
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.patch(`/api/articles`, {
                    ids: ids
                })
                    .then((response) => {
                        handleGetArticles()
                        ElMessage({
                            showClose: true,
                            message: response.data.message,
                            type: 'success',
                        })
                    })
                    .catch((error) => {
                        ElMessage({
                            showClose: true,
                            message: 'error',
                            type: 'success',
                        })
                    })
                    .finally(() => {
                        loading.value = false
                    })
            })
        }

        onMounted(() => {
            store.commit('app/setBreadcrumb', {
                title: 'Article',
                subtitle: 'Articles List'
            })

            handleGetArticles()
        })

        watch(searchQuery, (value) => {
            searchQuery.value = value
            let returnedFunction = debounce(function() {
                handleGetArticles()
            }, 250);

            returnedFunction()
        })

        return {
            multipleTableRef,
            multipleSelection,
            tableData,
            totalData,
            detailData,
            searchQuery,
            currentPage,
            pageOptions,
            pageSize,
            loading,
            meta,
            createArticle,
            editArticle,
            detailArticle,
            handleDelete,
            handleSelectionChange,
            toggleSelection,
            handleCurrentChange,
            handleSizeChange,
            Search,
            Refresh,
            EditPen,
            View,
            Delete,
            formatDate
        }
    }
}

</script>
