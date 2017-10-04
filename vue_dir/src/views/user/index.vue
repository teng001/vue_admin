<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-button type="primary" class="permission-add" @click="add">添加用户</el-button>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24">
        <el-table :data="tableData" style="width: 100%">
          <el-table-column prop="id" label="ID" width="180">
          </el-table-column>
          <el-table-column prop="username" label="用户名" width="180">
          </el-table-column>
          <el-table-column prop="email" label="邮箱">
          </el-table-column>
          <el-table-column label="操作" width="200">
            <template scope="scope">
              <el-button @click="edit(scope.$index)" type="primary" size="small">编辑</el-button>
              <el-button @click="del(scope.$index)" type="primary" size="small">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="12" class="mr10">
        <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="pageData.page" :page-sizes="[10, 20, 30, 40]" :page-size="pageData.perPage" layout="total, sizes, prev, pager, next, jumper" :total="pageData.total">
        </el-pagination>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchUserList } from '@/api/user'
export default {
  methods: {
    getpagelist() {
      fetchUserList(this.pageData).then(response => {
        this.tableData = response.data.data.data
        this.pageData.total = response.data.data.total
      })
    },
    handleSizeChange(val) {
      this.pageData.perPage = val
      this.getpagelist()
    },
    handleCurrentChange(val) {
      this.pageData.page = val
      this.getpagelist()
    },
    edit(id) {
      this.$router.push({ path: '/permission/user/detail/' + this.tableData[id].id })
    },
    add() {
      this.$router.push({ path: '/permission/user/detail/0' })
    },
    del(id) {
      console.log(id)
    }
  },
  created() {
    this.getpagelist()
  },
  data() {
    return {
      pageData: {
        page: 1,
        perPage: 10,
        keyWord: '',
        total: 0
      },
      tableData: []
    }
  }
}

</script>
<style rel="stylesheet/scss" lang="scss" scoped>
.mr10 {
  margin: 10px;
  float: right
}

.permission-add {
  float: right;
  margin: 10px;
}

</style>