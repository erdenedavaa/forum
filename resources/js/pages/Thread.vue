<script>
import Replies from '../components/Replies';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    // name: "Thread",
    props: ['initialRepliesCount'],

    components: {Replies, SubscribeButton},
    // ene bol child component

    data() {
        return {
            repliesCount: this.initialRepliesCount
        }
    },
}
</script>

