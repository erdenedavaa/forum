<script>
import Replies from '../components/Replies';

export default {
    // name: "Thread",
    props: ['initialRepliesCount'],

    components: {Replies},
    // ene bol child component

    data() {
        return {
            repliesCount: this.initialRepliesCount
        }
    },
}
</script>

