<script setup>

    import {ref, onMounted} from 'vue'
    import {format} from 'date-fns'
    const tab = ref(null)
    const announcements = ref(null)
    onMounted(() => {
        let data = new FormData();
        data.append('method','getAllAnnouncements')
        fetch('http://localhost:4545/index.php',
            {
                method:'POST',
                body:data
            }
        )
        .then(res =>{
            return res.text();
        })
        .then(data =>{
            announcements.value = JSON.parse(data);
        })
    })


  
</script>

<template>
    
    <v-card>
        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
            <v-tab :value="1">Announcements</v-tab>
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item>
                <v-container fluid>
                    <v-row>
                        <v-col v-for="(announcement, i) in announcements" :key="announcement.id" cols="12" md="4">
                            <v-card>
                                <v-img
                                    :src="`http://localhost:4545/admin/images.php?filename=${announcement.photo}`"
                                    :lazy-src="`https://picsum.photos/10/6?image=${i * (i + 2) * 5 + 10}`"
                                    cover
                                />
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
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
        </v-window>
    </v-card>

</template>
