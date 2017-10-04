<template>
  <div class="app-container">
    <el-row>
      <el-col :span="8">
        <el-form ref="permissionRole" :model="permissionRole" label-width="80px">
          <el-form-item label="角色名称">
            <el-input disabled v-model="roleDetail.name"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="onSubmit">保存</el-button>
            <el-button>取消</el-button>
          </el-form-item>
        </el-form>
      </el-col>
      <el-col :span="4">
      </el-col>
      <el-col :span="12">
        <el-tree :data="permissionList" show-checkbox :default-checked-keys="permissionRole.permissionArr" node-key="id" :props="defaultProps" accordion @check-change="handleCheckChange" :render-content="renderContent">
        </el-tree>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchPermissionList } from '@/api/permission'
import { fetchRoleDetail, fetchSavePermissionRole } from '@/api/role'
// import { mapGetters } from 'vuex'
import { removeByValue } from '@/utils'
export default {
  data() {
    return {
      permissionList: [],
      permissionRole: {
        id: '',
        permissionArr: []
      },
      // checkPermission: [],    //  选中的元素节点列表
      roleDetail: '',
      defaultProps: {
        children: 'children',
        label: 'name',
        path: 'path'
      }
    }
  },
  // computed: {
  //   ...mapGetters([
  //     'roles'
  //   ])
  // },
  // watch: {
  //   role(val) {
  //     this.$store.dispatch('ChangeRole', val).then(() => {
  //       this.$router.push({ path: '/permission/index?' + +new Date() })
  //     })
  //   }
  // },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      const id = this.$route.params.id
      this.permissionRole.id = id
      fetchRoleDetail(id).then(response => {
        this.roleDetail = response.data.data
        this.permissionRole.permissionArr = response.data.data.checklist
        fetchPermissionList().then(response => {
          const items = response.data.data
          this.permissionList = items
          this.listLoading = false
        })
      })
    },
    onSubmit() {
      // this.permissionRole.permissionArr = cleanArray(this.permissionRole.permissionArr)
      // objectMerge(this.permissionRole.permissionArr, this.checkPermission)
      this.$refs.permissionRole.validate(valid => {
        if (valid) {
          this.loading = true
          fetchSavePermissionRole(this.permissionRole).then(response => {
            console.log(response)
          })
          this.$notify({
            title: '成功',
            message: '发布文章成功',
            type: 'success',
            duration: 2000
          })
          this.loading = false
        } else {
          console.log('error submit!!')
          return false
        }
      })
    //     if (valid) {
    //       this.loading = true
    //       fetchSavePermissionRole(this.permissionDetail).then(response => {
    //         console.log(response)
    //       })
    //       this.$notify({
    //         title: '成功',
    //         message: '发布文章成功',
    //         type: 'success',
    //         duration: 2000
    //       })
    //       this.loading = false
    //     } else {
    //       console.log('error submit!!')
    //       return false
    //     }
    // })
    },
    handleCheckChange(data, checked, indeterminate) {
      if (checked) {
        this.permissionRole.permissionArr.push(data.id)
        // this.permissionRole.permissionArr[data.id] = data.id
      } else {
        removeByValue(this.permissionRole.permissionArr, data.id)
        // this.permissionRole.permissionArr = this.permissionRole.permissionArr.splice(data.id, 1)
      }
    },
    renderContent(h, { node, data, store }) {
      return (<span>
            <span>
            <span class = 'permission-w100' > { data.id } </span>
            <span class = 'permission-w100' > </span>
            <span class = 'permission-w100' > { node.label } </span>
            </span>
            </span>)
    }
  }
}

</script>
<style rel="stylesheet/scss" lang="scss" scoped>
.el-tree {
  border: none;
}

.permission-ml {
  margin-left: 100px;
}

.permission-add {
  float: right;
  margin: 10px;
}

</style>
