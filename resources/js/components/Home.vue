<template>
    <div class="home-container">
        <nav class="navbar">
            <ul>
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/register">Register</router-link></li>
                <li><router-link to="/login">Login</router-link></li>
            </ul>
        </nav>

        <header>
            <h1>Welcome to Our Platform</h1>
            <p>Your gateway to comprehensive services</p>
        </header>

        <section class="companies-section">
            <h2>Companies</h2>
            <div class="companies-list">
                <div class="company-card" v-for="company in companies" :key="company.id">
                    <h3>{{ company.company_name }}</h3>
                    <p>{{ company.description }}</p>
                    <p><strong>Email:</strong> {{ company.company_email }}</p>
                    <p><strong>Location:</strong> {{ company.country }}</p>
                    <p><strong>Users:</strong> {{ company.total_company_count }}</p>
                </div>
            </div>
        </section>

        <section class="services-section">
            <h2>Services Offered</h2>
            <div class="services-list">
                <div class="service-card" v-for="service in services" :key="service.id">
                    <h3>{{ service.name }}</h3>
                    <p>{{ service.description }}</p>
                    <p><strong>Offered by:</strong></p>
                    <ul>
                        <li v-for="company in service.companies" :key="company.id">{{ company.name }}</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Home',
    data() {
        return {
            companies: [],
            services: []
        };
    },
    created() {
        this.fetchCompanies();
        this.fetchServices();
    },
    methods: {
        async fetchCompanies() {
            try {
                const response = await axios.get('/api/companies');
                this.companies = response.data;
            } catch (error) {
                console.error('Error fetching companies:', error);
            }
        },
        async fetchServices() {
            try {
                const response = await axios.get('/api/services');
                this.services = response.data;
            } catch (error) {
                console.error('Error fetching services:', error);
            }
        }
    }
};
</script>
