<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Bookmark</h1>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>ID</td>
                    <td>{{ bookmark.id }}</td>
                </tr>
                <tr>
                    <td>Created at</td>
                    <td>{{ bookmark.created_at }}</td>
                </tr>
                <tr>
                    <td>Favicon</td>
                    <td><img :src="bookmark.favicon_url" alt="favicon" style="width: 16px"></td>
                </tr>
                <tr>
                    <td>URL</td>
                    <td>{{ bookmark.url }}</td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td>{{ bookmark.title }}</td>
                </tr>
                <tr>
                    <td>Meta description</td>
                    <td>{{ bookmark.meta_description }}</td>
                </tr>
                <tr>
                    <td>Meta keywords</td>
                    <td>{{ bookmark.meta_keywords }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "../config/axios.js";
export default {
    name: "Item",
    data() {
        return {
            bookmark: [], // Initial state
        };
    },
    mounted() {
        this.getBookmark(this.$route.params.id);
    },
    methods: {
        async getBookmark(id) {
            let res = await axios.get(`/bookmarks/${id}`);
            this.bookmark = res.data.data;
        }
    },
};
</script>
