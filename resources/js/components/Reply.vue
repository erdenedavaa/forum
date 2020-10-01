<template>
    <div :id="'reply-'+id" class="my-2" v-bind:class="{ 'd-none': isDeleted }">
        <div class="card" >
            <div class="card-header"  :class="isBest? 'bg-success text-white' : ''">
                <div class="d-flex justify-content-between align-items-center" >
                    <h6 class="mb-0">
                        <a :href="'/profiles/'+data.owner.name"
                            v-text="data.owner.name">
                        </a> said <span v-text="ago"></span>
                        <!-- moment.js time deer dajgui gej bn. Front
                         endees bid Carbon helder ruu can't access -->
                    </h6>

                    <div v-if="signedIn">
                        <favorite :reply="data"></favorite>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div v-if="editing">
                    <form @submit="update">
                        <div class="form-group">
                            <textarea class="form-control" v-model="body" required></textarea>
                        </div>

                        <button class="btn btn-sm btn-primary">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                    </form>

                </div>

                <div v-else v-html="body"></div>
            </div>

            <div class="card-footer d-flex">
                <div v-if="authorize('updateReply', reply)">
                    <button class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>
                    <button class="btn btn-danger btn-sm mr-2" @click="destroy">Delete</button>
                </div>

                <button class="btn btn-sm ml-auto" @click="markBestReply" v-show="! isBest">Best Reply?</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        name: "Reply",

        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isDeleted: false,
                isBest: false,
                reply: this.data
            };
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...';
            },

            // signedIn() {
            //     return window.App.signedIn;
            // }
            // app.js deer VUe.prototype deer zaagaad ugsun tul global bolchij bga ium shig bn.


        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.data.id,
                    {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });


                this.editing = false;

                flash('Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                // Jeffrey solution
                this.$emit('deleted', this.data.id);
            },

            markBestReply() {
                this.isBest = true;
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
