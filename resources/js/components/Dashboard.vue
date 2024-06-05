<!-- <template>
    <div>
        <h1>Dashboard</h1>
        <p>This is the dashboard. You must be logged in to view this page.</p>
    </div>
</template>

<script>
export default {
    name: 'Dashboard',
};
</script> -->

<template>
    <div class="dashboard-container">
        <nav class="navbar">
            <ul>
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/dashboard">Dashboard</router-link></li>
                <li @click="logout">Logout</li>
            </ul>
        </nav>

        <header>
            <h1>Welcome, {{ user.full_name }}</h1>
        </header>

        <section class="user-details">
            <h2>Your Details</h2>
            <p><strong>Full Name:</strong> {{ user.full_name }}</p>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Phone:</strong> {{ user.mobile }}</p>
            <p><strong>Address:</strong> {{ user.address }}</p>
            <p><strong>Company:</strong> {{ user.company ? user.company.name : '' }}</p>
            <p><strong>Country:</strong> {{ user.country ? user.country.name : '' }}</p>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Dashboard',
    data() {
        return {
            user: {}
        };
    },
    created() {
        this.fetchUser();
    },
    methods: {
        async fetchUser() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                this.user = response.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
                if (error.response && error.response.status === 401) {
                    this.$router.push('/login');
                }
            }
        },
        logout() {
            localStorage.removeItem('token');
            this.$router.push('/login');
        }
    }
};
</script>