<template>
    <MainLayout>
        <div class="d-flex justify-content-center">
            <div class="card login-card">
                <div class="card-body">
                    <form class="login-form">
                        <h3 class="text-center mb-5">Log to system</h3>

                        <div class="form-outline">
                            <label class="form-label">Email</label>
                            <input
                                v-model="formData.email"
                                class="form-control"
                                :class="{'is-invalid': formErrors.password}"
                            />
                            <div class="invalid-feedback invalid-feedback_invisible">
                                {{ formErrors.email }}
                            </div>
                        </div>

                        <div class="form-outline">
                            <label class="form-label">Password</label>
                            <input
                                v-model="formData.password"
                                type="password"
                                class="form-control"
                                :class="{'is-invalid': formErrors.password}"
                            />
                            <div class="invalid-feedback invalid-feedback_invisible">
                                {{ formErrors.password }}
                            </div>
                        </div>

                        <v-button
                            :loading="isLoadingSubmit"
                            class="w-100 mt-4"
                            color="primary"
                            @click="login"
                        >
                            Sign in
                        </v-button>
                    </form>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../layouts/MainLayout.vue";
import VButton from "../components/common/VButton.vue";

export default {
    name: "LoginPage",
    data() {
        return {
            formData: {
                email: "",
                password: "",
            },
            formErrors: {
                email: null,
                password: null,
            },
            isLoadingSubmit: false,
        }
    },
    components: {VButton, MainLayout},
    methods: {
        validate() {
            let isValid = true;

            if (!this.formData.email) {
                this.formErrors.email = "The email is required";
                isValid = false;
            } else {
                this.formErrors.email = null;
            }

            if (!this.formData.password) {
                this.formErrors.password = "The password is required";
                isValid = false;
            } else {
                this.formErrors.password = null;
            }

            return isValid;
        },

        login() {
            if (!this.validate()) {
                return;
            }

            this.isLoadingSubmit = true;

            const payload = {
                email: this.formData.email,
                password: this.formData.password,
            }

            this.$store.dispatch("login", payload)
                .then((response) => {
                    const data = response.data;

                    this.$store.commit("setUserToken", data.token);
                    this.$store.commit("setUserInfo", data.user);

                    this.$router.push('/');
                })
                .finally(() => {
                    this.isLoadingSubmit = false;
                });
        },
    }
}
</script>

<style scoped>
.login-card {
    width: 550px;
    margin: 50px 0;
}

.login-form {
    padding: 30px 30px 60px 30px;
}
</style>
