<script>
import { ref } from "@vue/composition-api";
export default {
    name: 'UserCan',
    setup() {
        const UserCan = ref(true);
        
        return { UserCan };
    },
    created()
    {
        console.log('hosl')
    }
}
</script>