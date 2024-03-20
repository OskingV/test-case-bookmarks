<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Data</h1>
                <router-link to="/create" class="btn btn-secondary">Create</router-link>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Created at</th>
                    <th>Favicon</th>
                    <th>URL</th>
                    <th>Title</th>
                    <th>View</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(bookmark, key) in bookmarks" :key="bookmark.id">
                    <td>{{ bookmark.created_at }}</td>
                    <td><img :src="bookmark.favicon_url" alt="favicon" style="width: 16px"></td>
                    <td>{{ bookmark.url }}</td>
                    <td>{{ bookmark.title }}</td>
                    <td>
                        <router-link
                            :to="{
                                name: 'Item',
                                params: { id: bookmark.id },
                            }"
                            to="/create" class="btn btn-secondary">
                            <font-awesome-icon :icon="['fas', 'eye']" />
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "../config/axios.js";
import toastr from "toastr";
export default {
    name: "List",
    data() {
        return {
            bookmarks: [], // Initial state
        };
    },
    mounted() {
        this.getBookmarks();
    },
    methods: {
        async getBookmarks() {
            let res = await axios.get('/bookmarks');
            this.bookmarks = res.data.data;
        }
    },
};
</script>
