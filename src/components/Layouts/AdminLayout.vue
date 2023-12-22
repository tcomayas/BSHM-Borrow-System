<script setup>

  import { ref, reactive } from 'vue'
  import { useRouter } from 'vue-router';
  import $ from 'jquery';
  import { useToastr } from '../../plugins/toastr';
  import { useAnnouncementStore } from '../../stores/announcement.js';
import Logo from "@/assets/logo.jpg";


  const announceStore = useAnnouncementStore();
  const toastr = useToastr();
  const createAccouncementDialog = ref(false)
  const loading = ref(false)
  const router = useRouter()
  const announcementForm = reactive({
      title: null,
      description: null,
      photo: null,
  });
  const api = 'http://localhost:4545/admin/router.php';

  function logout() {
      localStorage.removeItem('auth')
      router.push('/sign-up')
  }

  function storeAnnouncement() {
    loading.value = true;

    let formData = new FormData();
    formData.append('choice', 'announcement');
    formData.append('title', announcementForm.title);
    formData.append('description', announcementForm.description);
    if (announcementForm.photo) {
      formData.append('image', announcementForm.photo[0]);
    }

    $.ajax({
      type: 'POST',
      url: api,
      processData: false, 
      contentType: false,
      data: formData,
      success: data => {
        const res = JSON.parse(data);

        toastr["success"](res.message)

        announcementForm.title = null;
        announcementForm.description = null;
        announcementForm.photo = null;

        createAccouncementDialog.value = false;
        loading.value = false;

        announceStore.announcement = 'new announcement';

      },
      error: error => {
        console.log(error);
        createAccouncementDialog.value = false;
        loading.value = false;
      }
    })

    

  }

  const required = value => !!value || 'Required.'
  const counter = value => value.length <= 150 || 'Max 150 characters'
</script>

<template>

    <v-layout>
        <v-app-bar color="teal-darken-4" :src="Logo">
            <template v-slot:image>
                <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
            </template>

            <v-app-bar-title>BSHM</v-app-bar-title>
            <v-spacer></v-spacer>

            <router-link to="/admin/inventory">
              <v-btn color="white" prepend-icon="mdi-package-variant">
                Item Inventory
              </v-btn>
            </router-link>

            <v-btn @click="createAccouncementDialog = true" prepend-icon="mdi-plus">
                New announcement
            </v-btn>

            <router-link to="/admin/dashboard">
                <v-btn color="white" prepend-icon="mdi-view-dashboard-outline">
                    Dashboard
                </v-btn>
            </router-link>

            <router-link to="/admin/manage-users">
                <v-btn color="white" prepend-icon="mdi-account-supervisor-outline">
                    Manage users
                </v-btn>
            </router-link>

            <router-link to="#">
                <v-btn color="red" prepend-icon="mdi-logout" @click="logout()">
                    Logout
                </v-btn>
            </router-link>
            
        </v-app-bar>

        <v-main class="bg-grey-lighten-3">
            <v-container>
                <slot/>
            </v-container>
        </v-main>
    </v-layout>

    <v-dialog v-model="createAccouncementDialog" width="80%">
      <v-card title="New announcement">
        <v-card-text>
          <v-text-field label="Title" v-model="announcementForm.title"></v-text-field>
          <v-textarea :rules="[ required, counter ]" counter="150" label="Description" v-model="announcementForm.description"></v-textarea>
          <v-file-input  label="Photo" v-model="announcementForm.photo" accept="image/*"></v-file-input>
        </v-card-text>
        
        <v-card-actions>
          <v-spacer />
          <v-btn color="grey" @click="createAccouncementDialog = false">Cancel</v-btn>
          <v-btn color="green" @click="storeAnnouncement()" :loading="loading">Add</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</template>

<style scoped>

    .link {
        text-decoration: none;
    }

</style>
