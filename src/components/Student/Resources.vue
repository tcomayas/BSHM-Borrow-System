<template>
    <v-card>
        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
            <v-tab :value="0">Resources</v-tab>
            <v-tab :value="1">Borrowed Items</v-tab>
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item >
                <v-container fluid>
                    <v-row>
                        <v-col v-for="(item, index) in resources" :key="item.item_id" cols="12" md="4">
                            <DisplayResources :data="item" :index="index" @showEditAccouncementDialog="showBorrowDialog" />
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

            <v-window-item >
                <v-container fluid>
                    <v-row>
                        <v-col v-for="(item, index) in borrowedItems" :key="item.item_id" cols="12" md="4">
                            <BorrowedItems :data="item" :index="index" />
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
        </v-window>
    </v-card>

    <v-dialog v-model="borrowItemDialog" width="30%">
        <v-card :title="itemBorrow.item_name.toUpperCase()">
            <v-card-text>
                <v-text-field label="Item Quantity" type="number" v-model="itemQuantity"></v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="grey" @click="borrowItemDialog = false">Cancel</v-btn>
                <v-btn color="green" @click="borrowThisItem" :disabled="btnState.isDisabled" :loading="btnState.isLoading">Borrow</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, onMounted, defineAsyncComponent, watch } from 'vue';
import { useToastr } from '../../plugins/toastr.js';
import $ from 'jquery';

const DisplayResources = defineAsyncComponent({
    loader: () => import('./Resources/DisplayResources.vue'),
    delay: 300,
    timeout: 2300,
    suspensible: true
});

const BorrowedItems = defineAsyncComponent({
    loader: () => import('./Resources/BorrowedItems.vue'),
    delay: 300,
    timeout: 2300,
    suspensible: true
});

const btnState = ref({
    isLoading: false,
    isDisabled: false,
})
const toastr = useToastr();
const api = 'http://localhost:4545/admin/router.php';
const user = JSON.parse(localStorage.getItem('auth'));
const resources = ref([]);
const borrowedItems = ref([]);
const tab = ref(0);
const borrowItemDialog = ref(false);
const itemBorrow = ref({
    item_name: '',
    item_id: null,
    item_qty: null
});
const itemQuantity = ref(null)

const getUtilities = async (item_id) => {
    try {
        $.ajax({
            type: 'POST',
            url: api,
            data: {
                choice: 'get',
                item_id: 0
            },
            success: response => {
                const res = JSON.parse(response);
                if (res.status !== '403' || res.status !== '501') {
                    res.map(item => {
                        if (item.item_qty !== 0) {
                            resources.value.push(item)
                        }
                    });
                }
            },
            error: error => {
                toastr['error'](error.responseText);
                throw error;
            }
        })
    } catch (error) {
        toastr['error'](error.responseText);
        throw error;
    }
}

const getBorrowedItems = async () => {
    try {
        $.ajax({
            type: 'POST',
            url: api,
            data: {
                choice: 'my_item',
                user_id: user.id
            },
            success: response => {
                const res = JSON.parse(response);
                if (res.status !== '403' || res.status !== '501') {
                    borrowedItems.value = res;
                }
            },
            error: error => {
                toastr['error'](error.responseText)
                throw error;
            }
        })
    } catch (error) {
        toastr['error'](error.responseText)
        throw error;
    }
}

const showBorrowDialog = (item_id, item_name, item_qty) => {
    itemBorrow.value.item_name = item_name;
    itemBorrow.value.item_id = item_id;
    itemBorrow.value.item_qty = item_qty;
    borrowItemDialog.value = true;
}

const borrowThisItem = () => {
    try {
        btnState.isLoading = true;

        $.ajax({
            type: 'POST',
            url: api,
            data: {
                choice: 'borrow',
                user_id: user.id,
                item_id: itemBorrow.value.item_id,
                item_qty: itemQuantity.value
            },
            success: async response => {
                const res = JSON.parse(response);
                if (res.status === '201') {
                    toastr['success'](res.message);
                    resources.value = [];
                    borrowedItems.value = [];
                    await getUtilities();
                    await getBorrowedItems();
                } else {
                    toastr['error'](res.message);
                }
            },
            error: error => {
                toastr['error'](error.responseText);
                throw error;
            }
        })
    } catch (error) {
        toastr['error'](error.responseText);
        throw error;
    } finally {
        itemQuantity.value = null;
        btnState.isLoading = false;
        borrowItemDialog.value = false;
    }
}

onMounted(async () => {
    await getUtilities();
    await getBorrowedItems();
})

watch(itemQuantity, () => {
    if (parseInt(itemQuantity.value) > parseInt(itemBorrow.value.item_qty)) {
        btnState.value.isDisabled = true;
    } else {
        btnState.value.isDisabled = false;
    }
})
</script>