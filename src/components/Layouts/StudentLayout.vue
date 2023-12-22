<script setup>

    import {ref} from 'vue'
    const auth = ref(null)
    auth.value = JSON.parse(localStorage.getItem('auth'))

    function logout() {
        localStorage.removeItem('auth')
        auth.value = null
    }

</script>
<template>
    <v-layout>
        <v-app-bar color="teal-darken-4">
            <template v-slot:image>
              <v-img gradient="to top right, rgba(255,165,0,.8), rgba(255,200,150,.8)"></v-img>
            </template>
            <v-app-bar-title>BSHM</v-app-bar-title>
            <v-spacer></v-spacer>
            <div v-if="auth">
        <!-- <img :src="Logo" class="picture" /> -->
                <router-link to="/resources">
                    <v-btn color="white">
                      Resources
                    </v-btn>
                </router-link>
                
                <router-link to="/">
                    <v-btn color="white">
                        Announcements
                    </v-btn>
                </router-link>
                <router-link to="/account">
                    <v-btn color="white">
                        Account
                    </v-btn>
                </router-link>
                <router-link to="/sign-in">
                    <v-btn color="red" @click="logout">
                        Logout
                    </v-btn>
                </router-link>
            </div>
            <div v-else>
                <router-link to="/sign-in">
                    <v-btn color="white">
                        Sign in
                    </v-btn>
                </router-link>
                <router-link to="/sign-up">
                    <v-btn color="white">
                        Sign up
                    </v-btn>
                </router-link>
            </div>
        </v-app-bar>

        <v-main class="bg-grey-lighten-3">
            <v-container>
                <slot/>
            </v-container>
        </v-main>
    </v-layout>
</template>
<script>
// import Logo from "src/assets/logo.jpg";
</script>
<style scoped>
    .link {
        text-decoration: none;
    }
</style>
