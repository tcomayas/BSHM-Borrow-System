<template>
    <v-col cols="6">
        <v-text-field label="Item name" v-model="item.item_name" />
        <v-text-field label="Quantity" type="number" min="0" v-model="item.item_qty" />
        <v-file-input  label="Photo" v-model="file" @change="handleImageChange" accept="image/*" />
        
        <v-spacer />
        <v-btn color="green" @click="addNewItem" :disabled="btnState.isDisabled" :loading="btnState.isLoading">Add new item</v-btn>
    </v-col>

    <v-col cols="6">
        <v-img
            :src="imageUrl"
            cover
        />
    </v-col>
</template>

<script setup>
import { ref, watchEffect, inject } from 'vue';
import { useToastr } from '../../../plugins/toastr';
import $ from 'jquery';
import { useAnnouncementStore } from '../../../stores/announcement.js';

const announceStore = useAnnouncementStore();
const toastr = useToastr();
const api = 'http://localhost:4545/admin/router.php';
const btnState = ref({
    isLoading: false,
    isDisabled: true,
})
const item = ref({
    item_name: '',
    item_qty: null,
});
const file = ref(null);
const imageUrl = ref('');

const handleImageChange = () => {
    btnState.value.isLoading = true;
    imageUrl.value = '';

    if (file.value) {
        const reader = new FileReader();
        reader.onload = () => {
            imageUrl.value = reader.result;
            btnState.value.isLoading = false;
        };
        reader.readAsDataURL(file.value[0]);
    } else {
        imageUrl.value = '';
        btnState.value.isLoading = false;
    }
}

const addNewItem = () => {
    btnState.value.isDisabled = true;
    btnState.value.isLoading = true;

    const formData = new FormData();
    formData.append('choice', 'add_item');
    formData.append('item_name', item.value.item_name);
    formData.append('item_qty', item.value.item_qty);
    formData.append('image', file.value[0]);

    $.ajax({
        type: 'POST',
        url: api,
        processData: false, 
        contentType: false,
        data: formData,
        success: response => {
            const res = JSON.parse(response);
            toastr['success'](res.message);
            btnState.value.isLoading = false;
            announceStore.setChildState('Added item');
        },
        error: error => {
            toastr['error'](error.responseText);
            throw error;
        }
    });
}

watchEffect(() => {
    if (item.value.item_name && item.value.item_qty && imageUrl.value) {
        btnState.value.isDisabled = false;
    }
});
</script>
