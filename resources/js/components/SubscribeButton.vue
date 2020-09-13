<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
export default {
    name: "SubscribeButton",
    props: ['active'],

    // deerh prop-oor active esehee shiidej bga tul hereggui bolson
    // data() {
    //     return {
    //         active: false
    //     }
    // },

    computed: {
        classes() {
            return ['btn', this.active ? 'btn-primary' : 'btn-outline-primary'];
        }
    },

    methods: {
        subscribe() {
            axios[
                (this.active ? 'delete' : 'post')
            ](location.pathname + '/subscriptions');

            this.active = ! this.active;
        }
    },
}
</script>

<style scoped>

</style>
