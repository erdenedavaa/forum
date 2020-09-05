<script>
    import Favorite from './Favorite.vue';

    export default {
        // name: "Reply",

        props: ['attributes'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.attributes.body,
                isDeleted: false
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id);

                // $(this.$el).fadeOut(300, () => {
                //     flash('Your reply has been deleted.');
                // });

                this.isDeleted = true;

                flash('Your reply has been deleted.');
            }
        }
    }
</script>

<!--<style scoped>-->
<!--    .fade-enter-active,-->
<!--    .fade-leave-active {-->
<!--        transition: opacity 1s-->
<!--    }-->

<!--    .fade-enter,-->
<!--    .fade-leave-to-->
<!--        /* .fade-leave-active in <2.1.8 */-->

<!--    {-->
<!--        opacity: 0-->
<!--    }-->
<!--</style>-->
