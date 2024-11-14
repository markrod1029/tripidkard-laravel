import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authErrors: [], // Declare authErrors in the state to avoid reference issues
    }),
    getters: {
        user: (state) => state.authUser,
        isAuthenticated: (state) => !!state.authUser,
    },
    actions: {
        async initializeAuthUser() {
            const storedUser = localStorage.getItem("authUser");
            if (storedUser) {
                try {
                    this.authUser = JSON.parse(storedUser);
                } catch (error) {
                    console.error("Error parsing authUser from localStorage:", error);
                    localStorage.removeItem("authUser");
                    this.authUser = null;
                }
            }
        },

        async getToken() {
            try {
                await axios.get('/csrf-token');
            } catch (error) {
                console.error("Error fetching CSRF token:", error);
            }
        },

        async getUser() {
            await this.getToken();
            try {
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
            await this.getToken();
            try {
                const response = await axios.post("/login", {
                    email: data.email,
                    password: data.password,
                });

                if (response.data.message) {
                    return { general: response.data.message };
                }

                this.authUser = response.data.user;
                localStorage.setItem("authUser", JSON.stringify(this.authUser));

                return null;
            } catch (error) {
                console.error("Error logging in:", error);
                if (error.response && error.response.status === 403) {
                    return { general: error.response.data.message };
                }
                if (error.response && error.response.data.errors) {
                    return error.response.data.errors;
                } else {
                    return { general: "An error occurred during login." };
                }
            }
        },

        async adminLoginForm(data) {
            await this.getToken();
            try {
                const response = await axios.post("/admin/login", {
                    email: data.email,
                    password: data.password,
                });

                if (response.data.message) {
                    return { general: response.data.message };
                }

                this.authUser = response.data.user;
                localStorage.setItem("authUser", JSON.stringify(this.authUser));

                return null;
            } catch (error) {
                console.error("Error logging in:", error);
                if (error.response && error.response.status === 403) {
                    return { general: error.response.data.message };
                }
                if (error.response && error.response.data.errors) {
                    return error.response.data.errors;
                } else {
                    return { general: "An error occurred during login." };
                }
            }
        },

        async logout() {
            await this.getToken();
            try {
                await axios.post("/logout");
                this.authUser = null;
                localStorage.removeItem("authUser");
            } catch (error) {
                console.error("Error logging out:", error);
            }
        },

        async handleForgotPassword(email) {
            this.authErrors = [];
            try {
                const response = await axios.post("/forgot-password", {
                    email: email,
                });
                return response.data;
            } catch (error) {
                console.error("Error sending password reset email:", error);
                return { error: "An error occurred while sending the password reset email." };
            }
        },

        // Moved handleResetPassword inside actions and fixed syntax
        async handleResetPassword(resetData) {
            this.authErrors = [];
            await this.getToken();
            try {
                const response = await axios.post("/reset-password", resetData);
                return response.data;
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    return error.response.data.errors;
                }
                console.error("Error resetting password:", error);
                return { general: "An error occurred while resetting the password." };
            }
        },
    },
});
