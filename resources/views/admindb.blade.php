<html>
<body>
    <div id="admin_manager">

        <table border="1">
            <tr>
                <td>管理者ID</td>
                <td>管理者レベル</td>
            </tr>
            <tr v-for="m in admins">
                <td v-text="m.admin_id"></td>
                <td v-text="m.admin_authority"></td>
            </tr>
        </table>

    </div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script>
new Vue({
    el: '#admin_manager',
    data: {
        admins: []
    },
    methods: {
         getMessages() {

        const url = 'ajax/admindb';
        axios.get(url)
            .then((response) => {

                this.admins = response.data;

            });

        }
    },
    mounted() {

        this.getMessages();

    }
});
    </script>
</body>
</html>