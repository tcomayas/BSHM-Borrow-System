<template>
    <v-layout>
        <v-app-bar color="teal-darken-4">
            <template v-slot:image>
              <v-img gradient="to top right, rgba(255,165,0,.8), rgba(255,200,150,.8)"></v-img>
            </template>
            <v-app-bar-title>Lorem ipsum</v-app-bar-title>
            <v-spacer></v-spacer>
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
        </v-app-bar>

        <v-main class="bg-grey-lighten-3">
            <v-container>
                <slot/>
            </v-container>
        </v-main>
    </v-layout>
</template>

<style scoped>
    .link {
        text-decoration: none;
    }
</style>
