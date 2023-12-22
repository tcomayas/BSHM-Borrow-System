import { defineStore } from 'pinia';

export const useAnnouncementStore = defineStore('announcement', {
    state: () => ({
        announcement: '',
        childState: '',
    }),
    actions: {
        newAnnouncement(word) {
            this.announcement = word;
        },
        setChildState(word) {
            this.childState = word;
        },
    },
});
