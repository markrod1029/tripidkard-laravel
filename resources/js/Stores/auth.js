import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        // authUser: null,
        authUser: JSON.parse(localStorage.getItem("authUser")) || null,

    }),
    getters: {
        user: (state) => state.authUser,
        isAuthenticated: (state) => !!state.authUser,

    },
    actions: {


        async getUser() {
            try {
                const response = await axios.get("/api/profile");
                this.authUser = response.data;
                localStorage.setItem("authUser", JSON.stringify(this.authUser));
            } catch (error) {
                this.authUser = null;
                console.error("Error fetching user data:", error);
                this.authUser = null;
                localStorage.removeItem("authUser");
            }
        },
        async loginForm(data) {
            try {
                const response = await axios.post("/login", {
                    email: data.email,
                    password: data.password,
                });
                this.authUser = response.data.user;
                localStorage.setItem("authUser", JSON.stringify(this.authUser));
                return null;
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    return error.response.data.errors;
                } else {
                    console.error("Error logging in:", error);
                    return { general: "An error occurred during login." };
                }
            }
        },

        async registerForm(data) {
            try {
                const response = await axios.post("/register", {
                    first_names: data.first_name,
                    last_name: data.last_name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation,
                });
                this.authUser = response.data.user; // assuming response contains user data
                return null; // No errors, registration successful
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    return error.response.data.errors; // Return errors to be handled in the component
                } else {
                    console.error("Error registering:", error);
                    return {
                        general: "An error occurred during registration.",
                    }; // General error message
                }
            }
        },

        async logout() {
            try {
                await axios.post("/logout");
                this.authUser = null;
                localStorage.removeItem("authUser");
            } catch (error) {
                console.error("Error logging out:", error);
            }
        },
    },
    persist: {
        enabled: true,
        strategies: [
            {
                key: "authUser",
                storage: localStorage,
            },
        ],
    },
});
