<template>
    <div>
        <button class="btn-success w3-border w3-border-red w3-round-large" @click="logout">Logout</button>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    methods: {
        async logout() {
            console.log('Logout function called.');
            try {
                await axios.post('/api/logout');
                window.location.replace('/login');
            } catch (error) {
                console.error('Error during logout:', error);
            }
        },
    },
};
</script>