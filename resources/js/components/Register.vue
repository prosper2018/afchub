<template>
    <div class="login-container">
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" v-model="full_name" >
                <span v-if="errors.full_name" class="error">{{ errors.full_name[0] }}</span>
            </div>
            <div class="form-group">
                <label>Company:</label>
                <select v-model="company" >
                    <option value="" disabled>Select Company</option>
                    <option v-for="company in companies" :key="company.id" :value="company.id">
                        {{ company.company_name }}
                    </option>
                </select>
                <span v-if="errors.company_id" class="error">{{ errors.company_id[0] }}</span>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" v-model="email" >
                <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" v-model="mobile" >
                <span v-if="errors.mobile" class="error">{{ errors.mobile[0] }}</span>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" v-model="password" >
                <span v-if="errors.password" class="error">{{ errors.password[0] }}</span>
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" v-model="password_confirmation" >
                <span v-if="errors.password_confirmation" class="error">{{ errors.password_confirmation[0] }}</span>
            </div>
            <div class="form-group">
                <label>Pasport:</label>
                <input type="file" @change="handleFileUpload">
                <span v-if="errors.image_path" class="error">{{ errors.image_path[0] }}</span>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <input type="text" v-model="address" >
                <span v-if="errors.address" class="error">{{ errors.address[0] }}</span>
            </div>
            <div class="form-group">
                <label>Country:</label>
                <select v-model="country" >
                    <option value="" disabled>Select Country</option>
                    <option v-for="country in countries" :key="country.id" :value="country.id">
                        {{ country.name }}
                    </option>
                </select>
                <span v-if="errors.country" class="error">{{ errors.country[0] }}</span>
            </div>
            <div v-if="errors.general" class="error">{{ errors.general }}</div>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            full_name: '',
            email: '',
            mobile: '',
            address: '',
            country: '',
            countries: [],
            company: '',
            companies: [],
            password: '',
            password_confirmation: '',
            image_path: null, // Ensure image_path is initialized to null
            errors: {},
        };
    },
    created() {
        this.fetchCompanies();
        this.fetchCountries();
    },
    methods: {
        async fetchCompanies() {
            try {
                const response = await axios.get('/api/companies');
                this.companies = response.data;
            } catch (error) {
                this.errors.general = 'Error fetching companies';
                console.error('Error fetching companies:', error); 
            }
        },
        async fetchCountries() {
            try {
                const response = await axios.get('/api/countries');
                this.countries = response.data;
            } catch (error) {
                this.errors.general = 'Error fetching countries';
                console.error('Error fetching countries:', error); 
            }
        },
        handleFileUpload(event) {
            this.image_path = event.target.files[0];
        },
        async register() {
            this.errors = {}; // Reset errors
            try {
                let formData = new FormData();
                formData.append('full_name', this.full_name);
                formData.append('email', this.email);
                formData.append('mobile', this.mobile);
                formData.append('address', this.address);
                formData.append('country', this.country);
                formData.append('company_id', this.company);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.password_confirmation);
                formData.append('image_path', this.image_path);

                const response = await axios.post('/api/register', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                localStorage.setItem('token', response.data.token);
                this.$router.push('/');
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

