<template>
  <div class="app-container">
    <el-form ref="permissionDetail" :model="permissionDetail" label-width="160px">
      <el-form-item label="权限名称">
        <el-input v-model="permissionDetail.display_name"></el-input>
      </el-form-item>
      <el-form-item label="路由路径">
        <el-input v-model="permissionDetail.name"></el-input>
      </el-form-item>
      <el-form-item label="前端组件（一级组件继承Layout）">
        <el-input v-model="permissionDetail.component"></el-input>
      </el-form-item>
      <el-form-item label="前端重定向地址">
        <el-input v-model="permissionDetail.redirect"></el-input>
      </el-form-item>
      <el-form-item label="是否前端路由">
        <el-select v-model="permissionDetail.is_menu" placeholder="请选择活动区域">
          <el-option :key="permissionDetail.is_menu" label="是" :value="1"></el-option>
          <el-option :key="permissionDetail.is_menu" label="否" :value="0"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="icon">
        <el-input v-model="permissionDetail.icon"></el-input>
      </el-form-item>
      <el-form-item label="meta">
        <el-input v-model="permissionDetail.meta"></el-input>
      </el-form-item>
      <el-form-item label="是否在菜单栏显示">
      	<el-select v-model="permissionDetail.noDropdown" placeholder="请选择活动区域">
          <el-option :key="permissionDetail.noDropdown" label="是" :value="0"></el-option>
          <el-option :key="permissionDetail.noDropdown" label="否" :value="1"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="描述">
        <el-input v-model="permissionDetail.description"></el-input>
      </el-form-item>
      <el-form-item label="排序">
        <el-input v-model="permissionDetail.sort"></el-input>
      </el-form-item>
      <el-form-item label="上级菜单">
        <el-select v-model="permissionDetail.pid" placeholder="请选上级菜单">
          <el-option v-for="item in menu_list" :key="permissionDetail.pid" :label="item.name" :value="item.id">
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">保存</el-button>
        <el-button>取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { fetchPermissionDetail, fetchSavePermission, getTreeMenu } from '@/api/permission'
export default {
  data() {
    return {
      permissionDetail: {
        id: '',
        name: '',
        display_name: '',
        component: 'Layout',
        redirect: '',
        is_menu: '',
        icon: '',
        meta: '',
        noDropdown: '',
        description: '',
        pid: 0,
        sort: 0
      },
      menu_list: []
    }
  },
  methods: {
    onSubmit() {
      this.$refs.permissionDetail.validate(valid => {
        if (valid) {
          this.loading = true
          fetchSavePermission(this.permissionDetail).then(response => {
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
    },
    getPermissionDetail() {
      const t = this
      const id = this.$route.params.id
      getTreeMenu().then(menuresponse => {
        t.menu_list = menuresponse.data.data
        fetchPermissionDetail(id).then(response => {
          if (response.data.data.id) {
            t.permissionDetail = response.data.data
          }
        }).catch(error => {
          console.log(error)
        })
      })
    }
  },
  created() {
    this.getPermissionDetail()
  }
}

</script>
