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
            <form action="">
                <div class="form-group">
                    <label for="title">Password</label>
                    <input type="password" name="password" id="password" class="form-control" v-model="bookmark.password" />
                </div>
                <button type="button" class="btn btn-danger" v-on:click="deleteBookmark()">Delete</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "../config/axios.js";
import toastr from "toastr";
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
        },
        async deleteBookmark() {
            try {
                await axios.delete(`/bookmarks/${this.bookmark.id}`, {
                    data: {
                        password: this.bookmark.password
                    }
                });
                this.$router.push({ name: 'List'})
            } catch (error) {
                toastr.error(error.response.data.message);
            }
        },
    },
};
</script>
