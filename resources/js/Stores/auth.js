import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
    }),
    getters: {
        user: (state) => state.authUser,
        isAuthenticated: (state) => !!state.authUser,
    },
    actions: {
        async getToken() {
            try {
                await axios.get('/csrf-token');
            } catch (error) {
                console.error("Error fetching CSRF token:", error);
            }
        },

        async getUser() {
            try {
                await this.getToken();
                const response = await axios.get("/api/profile");
                this.authUser = response.data;
                localStorage.setItem("authUser", JSON.stringify(this.authUser));
            } catch (error) {
                console.error("Error fetching user data:", error);
                this.authUser = null;
                localStorage.removeItem("authUser");
            }
        },

        async loginForm(data) {
            try {
                await this.getToken();
                const response = await axios.post("/login", {
                    email: data.email,
                    password: data.password,
                });
                this.authUser = response.data.user;

                console.log(this.authUser);
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

        async logout() {
            try {
                await this.getToken();
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
