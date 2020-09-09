<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                    <textarea name="body"
                              id="body"
                              rows="5"
                              class="form-control"
                              required
                              placeholder="Have something to say?"
                              v-model="body"></textarea>
            </div>

            <button type="submit"
                    class="btn btn-primary"
                    @click="addReply">Post</button>
        </div>


        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
export default {
    name: "NewReply",
    props: ['endpoint'],

    data() {
        return {
            body: ''
        };
    },

    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },

    methods: {
        addReply() {
            axios.post(this.endpoint, { body: this.body })
                // .then(response => {
                //     this.body = '';
                //
                //     flash('Your reply has been posted.');
                //
                //     this.$emit('created', response.data);

            // ES20!5 daraah shorthand bii bolson
                .then( ({data}) => {
                    this.body = '';

                    flash('Your reply has been posted.');

                    this.$emit('created', data);
                });
        }
    }
}
</script>

<style scoped>

</style>
