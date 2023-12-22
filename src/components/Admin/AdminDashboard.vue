<script setup>

    import { ref, onMounted, watch, reactive } from 'vue'
    import { format } from 'date-fns'
    import { useAnnouncementStore } from '../../stores/announcement.js';

    const announceStore = useAnnouncementStore();
    const tab = ref(null)
    const announcements = ref(null)
    const editAccouncementDialog = ref(false)
    const deleteAccouncementDialog = ref(false)
    const loading = ref(false)
    const updateAnnouncementForm = reactive({
        id: null,
        title: null,
        description: null,
        photo: null
    })

    const deleteAnnouncementForm = reactive({
        id: null,
        title: null
    })

    function showEditAccouncementDialog(announcement) {
        updateAnnouncementForm.id = announcement.id
        updateAnnouncementForm.title = announcement.title
        updateAnnouncementForm.description = announcement.description
        updateAnnouncementForm.photo = announcement.photo
        editAccouncementDialog.value = true
    }

    function showDeleteAccouncementDialog(announcement) {
        deleteAnnouncementForm.id = announcement.id
        deleteAnnouncementForm.title = announcement.title
        updateAnnouncementForm.photo = announcement.photo
        deleteAccouncementDialog.value = true
    }

    function updateAnnouncement() {
        loading.value = true
        let data = new FormData();
        data.append('method', 'updateAnnouncement');
        data.append('id', updateAnnouncementForm.id)
        data.append('title', updateAnnouncementForm.title)
        data.append('description', updateAnnouncementForm.description)
        data.append('photo', updateAnnouncementForm.photo)

        fetch(`http://localhost:4545/index.php`,
        {
            method: 'POST',
            body: data,
        })
        .then((response) => {
            return response.text()
        })
        .then((data) => {
            announcements.value = JSON.parse(data);
            console.log(data)
            editAccouncementDialog.value = false
            loading.value = false
        })
        .catch((error) => {
            editAccouncementDialog.value = false
            loading.value = false
        })
    }

    function deleteAnnouncement() {
        loading.value = true
        let data = new FormData();
        data.append('method', 'deleteAnnouncement');
        data.append('id', deleteAnnouncementForm.id)

        fetch(`http://localhost:4545/index.php`,
        {
            method: 'POST',
            body: data,
        })
        .then(res =>{
            return res.text();
        })
        .then(data =>{
            announcements.value = JSON.parse(data);
            deleteAccouncementDialog.value = false
            loading.value = false
        })
        .catch((error) => {
            console.log(error)
            deleteAccouncementDialog.value = false
            loading.value = false
        })
    }

    const getAnnouncements = () => {
      let data = new FormData();
      data.append('method','getAllAnnouncements')
      fetch('http://localhost:4545/index.php', { method:'POST', body:data })
        .then(res =>{
            return res.text();
        })
        .then(data =>{
            announcements.value = JSON.parse(data);
        })
    }

  const required = value => !!value || 'Required.'
  const counter = value => value.length <= 150 || 'Max 150 characters'

    onMounted(() => {
      getAnnouncements();
    })

    watch(() => announceStore.announcement, (val) => {
      if(val) {
        getAnnouncements();
      }
    })

</script>
<template>
    <v-card>
        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
            <v-tab :value="1">Announcements</v-tab>
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item >
                <v-container fluid>
                    <v-row>
                        <v-col v-for="(announcement, i) in announcements" :key="announcement.id" cols="12" md="4">
                            <v-card >
                                <v-img
                                  :src="`http://localhost:4545/admin/images.php?filename=${announcement.photo}`"
                                  :lazy-src="`https://picsum.photos/10/6?image=${i * (i+2) * 5 + 10}`"
                                  cover
                                ></v-img>
                                <v-card-title class="text-capitalize">
                                    {{ announcement.title }}
                                </v-card-title>
                                <v-card-subtitle>
                                    <v-icon>mdi-circle-medium</v-icon>
                                    {{ format(new Date(announcement.created_at), 'PPPP') }}
                                </v-card-subtitle>
                                <v-card-text>
                                    {{ announcement.description }}
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer/>
                                    <v-btn color="blue" prepend-icon="mdi-square-edit-outline" @click="showEditAccouncementDialog(announcement)">Edit</v-btn>
                                    <v-btn prepend-icon="mdi-delete-empty-outline" color="red" @click="showDeleteAccouncementDialog(announcement)">Delete</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
        </v-window>
  </v-card>

  <v-dialog v-model="editAccouncementDialog" width="80%">
        <v-card title="Edit announcement">
            <v-card-text>
                <v-text-field label="Title" v-model="updateAnnouncementForm.title"></v-text-field>
                <v-textarea :rules="[required, counter]" counter="70" label="Description" v-model="updateAnnouncementForm.description"></v-textarea>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="grey" @click="editAccouncementDialog = false">Cancel</v-btn>
                <v-btn color="green" @click="updateAnnouncement()" :loading="loading">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="deleteAccouncementDialog" width="80%">
        <v-card title="Delete announcement">
            <v-card-text>
                Are you sure you want to delete <strong>{{ deleteAnnouncementForm.title }}</strong>?
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="grey" @click="deleteAccouncementDialog = false">Cancel</v-btn>
                <v-btn color="red" @click="deleteAnnouncement()" :loading="loading">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>
