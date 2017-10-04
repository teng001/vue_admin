<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-button type="primary" class="permission-add" @click="add">添加权限</el-button>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24">
        <tree-grid :columns="columns" :tree-structure="true" :data-source="permissionList"></tree-grid>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import { fetchPermissionList, fetchPermissionDelete } from '@/api/permission'
// import { mapGetters } from 'vuex'
import { TreeGrid } from '@/components/TreeTable'
export default {
  data() {
    return {
      role: '',
      permissionList: [],
      columns: [{
        text: 'ID',
        dataIndex: 'id'
      },
      {
        text: '路由名称',
        dataIndex: 'name'
      },
      {
        text: '路由路径',
        dataIndex: 'path'
      }]
    }
  },
  components: {
    TreeGrid
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchPermissionList().then(response => {
        const items = response.data.data
        this.permissionList = items
        this.listLoading = false
      })
    },
    edit(store, data) {
      // console.log(store)
      console.log(data)
      this.$router.push({ path: '/permission/router/detail/' + data.id })
    },
    remove(store, data) {
      fetchPermissionDelete(data.id).then(response => {
        console.log(response)
      })
    },
    add() {
      this.$router.push({ path: '/permission/router/detail/0' })
    },
    handleNodeClick(data) {
      console.log(data)
    }
  }
}

</script>
<style rel="stylesheet/scss" lang="scss" scoped>
.permission-w100 {
  width: 200px;
  overflow: hidden;
}

.permission-ml {
  margin-left: 100px;
}

.permission-add {
  float: right;
  margin: 10px;
}

</style>
