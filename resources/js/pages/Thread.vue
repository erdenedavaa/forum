<script>
import Replies from '../components/Replies';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    // name: "Thread",
    props: ['thread'],

    components: {Replies, SubscribeButton},
    // ene bol child component

    data() {
        return {
            repliesCount: this.thread.replies_count,
            // this is coming from eloquent query results
            locked: this.thread.locked,
            editing: false
        }
    },

    methods: {
        toggleLock() {

           // axios.post('/locked-threads/' + this.thread.slug);
            // toggle hiij bga tul deerhiig daraah baidlaar hiine

            axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

            this.locked = ! this.locked;
        }
    }
}
</script>

