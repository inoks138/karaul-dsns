<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-5">
        <component :is="isUserLogged ? 'router-link' : 'span'"
            to="/"
            class="navbar-brand p-0"
        >
            <img
                src="/img/dsns-logo.png"
                alt="dsns-logo"
                width="44px"
                height="44px"
            >
        </component>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" >
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <div v-if="isUserLogged" class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ getUserName }}
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown" >
                    <div class="btn dropdown-item" tabindex="0" @click="logout">Logout</div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>

export default {
    name: 'Navbar',
    computed: {
        isUserLogged() {
            return !!this.$store.state.auth.user.token;
        },
        getUserName() {
            return this.$store.state.auth.user.name;
        },
    },
    methods: {
        logout() {
            this.$store.dispatch("logout")
                .then(() => {
                    this.$store.dispatch("resetUser");

                    this.$router.push('/login');
                });
        },
    },
};
</script>

<style scoped>
button a, .v-list-item a {
    text-decoration: none;
    color: inherit;
}
</style>
