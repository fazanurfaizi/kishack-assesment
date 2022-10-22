<template>
    <div>
        <div class="row mb-3">
            <div class="col-md-7 col-12">
                <el-button
                    v-if="multipleSelection.length > 0"
                    :icon="Delete"
                    circle
                    class="mx-2 text-danger bg-transparent border-0"
                    @click="dialogVisible = true"
                />

                <el-input
                    v-model="searchQuery"
                    placeholder="Search"
                    :suffix-icon="Search"
                    style="width: 80%;"
                />

                <el-button :icon="Refresh" circle class="mx-2 text-primary bg-transparent border-0" />
            </div>
            <div class="col-md-5 col-12 d-flex justify-content-end">
                <button
                    class="btn btn-blue-gradient w-25"
                    type="button"
                    @click="formVisible = true"
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
                        @click.prevent="editRow(scope.row)"
                        :icon="EditPen"
                    />
                    <el-button
                        type="primary"
                        size="small"
                        @click.prevent="detailRow(scope.row)"
                        :icon="View"
                    />
                </template>
            </el-table-column>
            <el-table-column prop="name" label="Name" sortable />
            <el-table-column prop="slug" label="Slug" sortable />
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

    <el-dialog v-model="formVisible" :title="`${formTitle} Roles`" width="40%">
        <div class="row">
            <div class="col-6 form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Input roles name" v-model="form.name">
            </div>
            <div class="col-6 form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" id="slug" placeholder="Input Slug" v-model="form.slug">
            </div>
        </div>

        <div class="row mt-3">
            <el-table
                :data="permissionsData"
                :default-sort="{ prop: 'date', order: 'descending' }"
                ref="multipleTablePermissionRef"
                style="width: 100%"
                @selection-change="handleSelectionPermissionChange"
                stripe
                table-layout="fixed"
            >
                <el-table-column type="selection" width="100" />
                <el-table-column prop="name" label="Name" sortable />
                <el-table-column prop="slug" label="Slug" sortable />
            </el-table>

            <div class="d-flex justify-content-between mt-2">
                <el-pagination
                    background
                    layout="prev, pager, next"
                    v-model:currentPage="currentPagePermission"
                    v-model:page-size="pageSizePermission"
                    :total="permissionsTotal"
                    @current-change="handleCurrentChangePermission"
                />
            </div>
        </div>

        <template #footer>
            <div class="dialog-footer d-flex justify-content-between">
                <button class="btn btn-secondary text-white px-5" @click="formVisible = false">
                    Cancel
                </button>
                <button v-if="formTitle === 'Add'" class="btn btn-blue-gradient text-white px-5" @click="handlePost()">
                    {{ loading ? 'Saving...' : 'Save' }}
                </button>
                <button v-else class="btn btn-blue-gradient text-white px-5" @click="handlePut()">
                    {{ loading ? 'Updating...' : 'Update' }}
                </button>
            </div>
        </template>
    </el-dialog>

    <el-dialog v-model="detailVisible" title="Detail Roles" width="40%">
        <table class="table" v-if="detailData">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ detailData.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ detailData.name }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ detailData.slug }}</td>
                </tr>
                <tr>
                    <th>Log Info</th>
                    <td>{{ formatDate(detailData.created_at) }}</td>
                </tr>
            </tbody>
        </table>
    </el-dialog>

    <el-dialog
        v-model="dialogVisible"
        title="Warning"
        width="30%"
    >
        <span>Are you sure you want to delete items ?</span>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="danger" @click="handleDelete()">
                    Confirm
                </el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script>
import { ref, reactive, onMounted, watch } from 'vue'
import { useStore } from 'vuex'
import { ElMessage } from 'element-plus'
import { Search, Refresh, EditPen, View, Delete } from '@element-plus/icons-vue'
import axios from 'axios'
import { debounce, formatDate } from '@/utils/index.js'

export default {
    name: 'roles',
    setup() {
        const store = useStore()

        const loading = ref(false)

        const tableData = ref([])

        const permissionsData = ref([])

        const detailData = ref(null)

        const totalData = ref(0)

        const permissionsTotal = ref(0)

        const meta = ref({
            from: 0,
            to: 0
        })

        const formTitle = ref('Add')

        const multipleTableRef = ref(null)

        const multipleTablePermissionRef = ref(null)

        const multipleSelection = ref([])

        const multiplePermissionsSelection = ref([])

        const dialogVisible = ref(false)

        const toggleSelection = (rows) => {
            if (rows) {
                rows.forEach((row) => {
                    multipleTableRef.value.toggleRowSelection(row, undefined)
                })
            } else {
                multipleTableRef.value.clearSelection()
            }
        }

        const togglePermissionSelection = (rows) => {
            if (rows) {
                rows.forEach((row) => {
                    multipleTablePermissionRef.value.toggleRowSelection(row, undefined)
                })
            } else {
                multipleTablePermissionRef.value.clearSelection()
            }
        }

        const handleSelectionChange = (val) => {
            multipleSelection.value = val
        }

        const handleSelectionPermissionChange = (val) => {
            multiplePermissionsSelection.value = val
        }

        const searchQuery = ref('')

        const currentPage = ref(1)

        const currentPagePermission = ref(1)

        const pageSizePermission = ref(5)

        const pageSize = ref(5)

        const pageOptions = [5, 10, 25, 50]

        const handleSizeChange = (val) => {
            pageSize.value = val
            handleGetRoles()
        }

        const handleCurrentChange = (val) => {
            currentPage.value = val
            handleGetRoles()
        }

        const handleCurrentChangePermission = (val) => {
            currentPagePermission.value = val
            handleGetPermissions()
        }

        const formVisible = ref(false)

        const detailVisible = ref(false)

        const form = reactive({
            name: '',
            slug: '',
        })

        const handleGetPermissions = async () => {
            loading.value = true
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get('/api/permissions', {
                    params: {
                        limit: pageSizePermission.value,
                        page: currentPagePermission.value
                    }
                })
                    .then((response) => {
                        permissionsData.value = response.data.data.data
                        permissionsTotal.value = response.data.data.total
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => {
                        loading.value = false
                    })
            })
        }

        const handleGetRoles = async () => {
            loading.value = true
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get('/api/roles', {
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

        const handlePost = async () => {
            loading.value = true
            const permissions = multiplePermissionsSelection.value.map((permission) => permission.id)
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.post('/api/roles', {
                    name: form.name,
                    slug: form.slug,
                    permissions
                })
                    .then((response) => {
                        handleGetRoles()
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
                        formVisible.value = false
                        form.name = ''
                        form.slug = ''
                        multiplePermissionsSelection.value = []
                    })
            })
        }

        const handlePut = async () => {
            loading.value = true
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.put(`/api/roles/${detailData.value.id}`, form)
                    .then((response) => {
                        handleGetRoles()
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
                        formVisible.value = false
                        form.name = ''
                        form.slug = ''
                        detailData.value = null
                    })
            })
        }

        const handleDelete = async () => {
            loading.value = true
            const ids = multipleSelection.value.map((value) => value.id)
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.patch(`/api/roles`, {
                    ids: [ids]
                })
                    .then((response) => {
                        handleGetRoles()
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
                        dialogVisible.value = false
                    })
            })
        }

        const detailRow = async (row) => {
            loading.value = true
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get(`/api/roles/${row.id}`)
                    .then((response) => {
                        detailData.value = response.data.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => {
                        loading.value = false
                        detailVisible.value = true
                    })
            })
        }

        const editRow = async (row) => {
            loading.value = true
            formTitle.value = "Edit"
            await axios.get('/sanctum/csrf-cookie').then(async () => {
                await axios.get(`/api/roles/${row.id}`)
                    .then((response) => {
                        detailData.value = response.data.data
                        form.name = response.data.data.name
                        form.slug = response.data.data.slug
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => {
                        loading.value = false
                        formVisible.value = true
                    })
            })
        }

        onMounted(() => {
            store.commit('app/setBreadcrumb', {
                title: 'Roles',
                subtitle: 'Roles List'
            })

            handleGetRoles()
            handleGetPermissions()
        })

        watch(searchQuery, (value) => {
            searchQuery.value = value
            let returnedFunction = debounce(function() {
                handleGetRoles()
            }, 250);

            returnedFunction()
        })

        return {
            formTitle,
            multipleTableRef,
            multipleTablePermissionRef,
            multipleSelection,
            multiplePermissionsSelection,
            tableData,
            totalData,
            permissionsData,
            permissionsTotal,
            detailData,
            searchQuery,
            currentPage,
            currentPagePermission,
            pageOptions,
            pageSize,
            pageSizePermission,
            formVisible,
            detailVisible,
            form,
            loading,
            meta,
            handlePost,
            handlePut,
            handleDelete,
            handleSelectionChange,
            handleSelectionPermissionChange,
            toggleSelection,
            togglePermissionSelection,
            handleCurrentChange,
            handleCurrentChangePermission,
            handleSizeChange,
            detailRow,
            editRow,
            Search,
            Refresh,
            EditPen,
            View,
            Delete,
            formatDate,
            dialogVisible
        }
    }
}

</script>
