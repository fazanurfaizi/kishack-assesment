<template>
    <div>
        <div class="row mb-3">
            <div class="col-7">
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
                        @click.prevent="detailRow(scope.row)"
                        :icon="EditPen"
                    />
                    <el-button
                        type="primary"
                        size="small"
                        @click.prevent="deleteRow(scope.row)"
                        :icon="EditPen"
                    />
                </template>
            </el-table-column>
            <el-table-column prop="title" label="Title Article" sortable />
            <el-table-column prop="category" label="Categories" sortable />
            <el-table-column prop="date" label="Created date" sortable />
        </el-table>

        <div class="d-flex justify-content-between">
            <el-pagination
                background
                layout="prev, pager, next"
                v-model:currentPage="currentPage"
                v-model:page-size="pageSize"
                :page-sizes="[10, 25, 50]"
                :total="1000"
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
            />
            <div class="px-2">
                <el-select v-model="pageSize" class="m-2" placeholder="Select" size="large" style="width: 75px;">
                    <el-option
                        v-for="item in pageOptions"
                        :key="item"
                        :label="item"
                        :value="item"
                    />
                </el-select>
                <span class="text-gray">Showing 1-5 of 10</span>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { Search, Refresh, EditPen } from '@element-plus/icons-vue'

export default {
    name: 'list-articles',
    setup() {
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

        const pageSize = ref(10)

        const pageOptions = [10, 25, 50]

        const handleSizeChange = (val) => {
            console.log(`${val} items per page`)
        }

        const handleCurrentChange = (val) => {
            console.log(`current page: ${val}`)
        }

        const detailRow = (row) => {
            console.log(row.id)
        }

        const deleteRow = (row) => {
            console.log(row)
        }

        const tableData = [
            {
                id: 1,
                date: '2016-05-03',
                title: 'Tom',
                category: 'News'
            },
            {
                id: 2,
                date: '2016-05-02',
                title: 'Tom',
                category: 'News'
            },
            {
                id: 3,
                date: '2016-05-04',
                title: 'Tom',
                category: 'News'
            },
            {
                id: 4,
                date: '2016-05-01',
                title: 'Tom',
                category: 'News'
            },
        ]

        return {
            multipleTableRef,
            tableData,
            searchQuery,
            currentPage,
            pageOptions,
            pageSize,
            handleSelectionChange,
            toggleSelection,
            handleCurrentChange,
            handleSizeChange,
            detailRow,
            deleteRow,
            Search,
            Refresh,
            EditPen
        }
    }
}

</script>