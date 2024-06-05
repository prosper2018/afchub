<template>
    <div class="login-container">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email">
                <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="password">
                <span v-if="errors.password" class="error">{{ errors.password[0] }}</span>
            </div>
            <div v-if="errors.general" class="error">{{ errors.general }}</div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errors: {},
        };
    },
    methods: {
        async login() {
            this.errors = {};
            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                });
                localStorage.setItem('token', response.data.token);
                this.$router.push('/dashboard');
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else if (error.response && error.response.status === 401) {
                    this.errors.general = 'Unauthorized';
                } else {
                    this.errors.general = 'An unexpected error occurred. Please try again.';
                    console.error('Error:', error);
                }
            }
        },
    },
};
</script>