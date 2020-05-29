<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-faded mb-4">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Activities Execute
                </a>
            </div>
        </nav>
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>

<script>

    export default{
    }
</script>
