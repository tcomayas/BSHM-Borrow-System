<style scoped>
    .card{
        display: flex;
        justify-content: space-around;
    }
    .picture{
        height: 400px;
        width: 400px;
        border-radius: 50%;
    }
    .login-card{
        width: 400px;
        margin-top: 100px;
        text-align: center;
    }
</style>

<template>
    <v-container class="card">
      <img :src="Logo" class="picture" />
  
      <v-form fast-fail @submit.prevent>
        <v-card title="Login" class="login-card">
          <v-card-item>
            <v-text-field :rules="email_rule" :error-messages="invalidLoginError" label="Email" v-model="user.email"></v-text-field>
            <v-text-field :rules="password_rule" label="Password" v-model="user.password" :type="showPassword ? 'text' : 'password'">
              <template v-slot:append-inner>
                <v-btn v-if="user.password" :icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'" @click="showPassword = !showPassword" variant="text" size="small"></v-btn>
              </template>
            </v-text-field>
          </v-card-item>
          <v-card-actions>
            <v-btn @click="signin" type="submit" :loading="loading">Sign in</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-container>
  </template>

<script setup>
import Logo from "@/assets/logo.jpg";
import {reactive, ref} from 'vue'
import { useRouter } from 'vue-router';
const loading = ref(false)
const student = ref(null)
const router = useRouter()
const showPassword = ref(false)
const error = ref(false)
const invalidLoginError = ref('')

const user = reactive({
    email: null,
    password: null,
})

function signin() {
    loading.value = true
    let data = new FormData();
    data.append('method', 'signin');
    data.append('email', user.email)
    data.append('password', user.password)

    fetch(`http://localhost:4545/index.php`,
    {
        method: 'POST',
        body: JSON.stringify({
          method: 'signin',
          email: user.email,
          password: user.password
        }),
    })
    .then((response) => {
      if(!response.ok) {
        throw new Error(response.statusText);
      }
      return response.json();
    })
    .then((data) => {
        student.value = data
        if(data.length !== 0) {
            localStorage.setItem('auth', JSON.stringify(student.value[0]))
            if(student.value[0].role == "Admin") {
                router.push('/admin/dashboard')
            }
            else {
                router.push('/')
            }
        }
        else {
            invalidLoginError.value = "Invalid credentials"
            error.value = true
        }
        loading.value = false
    })
    .catch((error) => {
        loading.value = false
        error.value = true
    })
}

const email_rule = [
    value => {
        if (/^[a-zA-Z0-9.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true
        return 'Must be a valid e-mail.'
    }
]

const password_rule = [
    value => {
        if (value) return true
        return 'Password field is required.'
    }
]



</script>
