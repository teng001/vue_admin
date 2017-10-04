<template>
  <div class="app-container">
    <el-form ref="userDetail" :model="userDetail" label-width="160px">
      <el-form-item label="用户名">
        <el-input disabled v-model="userDetail.username"></el-input>
      </el-form-item>
      <el-form-item label="邮箱">
        <el-input v-model="userDetail.email"></el-input>
      </el-form-item>
      <el-form-item label="是否超级管理员">
        <el-tooltip :content="'Switch value: ' + userDetail.is_super" placement="top">
          <el-switch v-model="userDetail.is_super" on-color="#13ce66" off-color="#ff4949" on-value="1" off-value="0">
          </el-switch>
        </el-tooltip>
      </el-form-item>
      <el-form-item>
        <el-checkbox-group v-model="userDetail.user_roles">
          <el-checkbox v-for="item in roleList" :label="item.id" :key="item.id" >{{item.display_name}}</el-checkbox>
        </el-checkbox-group>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">保存</el-button>
        <el-button>取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { fetchUserDetail, fetchSaveUser } from '@/api/user'
import { fetchUserRoleList } from '@/api/role'
export default {
  data() {
    return {
      userDetail: {
        id: '',
        username: '',
        email: '',
        is_super: '1',
        user_roles: ''
      },
      roleList: []
    }
  },
  methods: {
    onSubmit() {
      this.$refs.userDetail.validate(valid => {
        if (valid) {
          this.loading = true
          fetchSaveUser(this.userDetail).then(response => {
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
    getRoleDetail() {
      const t = this
      const id = this.$route.params.id
      fetchUserDetail(id).then(response => {
        if (response.data.data.id) {
          t.userDetail = response.data.data
          if (t.userDetail.is_super === 1) {
            t.userDetail.is_super = '1'
          } else {
            t.userDetail.is_super = '0'
          }
          fetchUserRoleList().then(response => {
            this.roleList = response.data.data
          })
        }
      }).catch(error => {
        console.log(error)
      })
    }
  },
  created() {
    this.getRoleDetail()
  }
}

</script>
