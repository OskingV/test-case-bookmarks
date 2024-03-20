<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Create bookmark</h1>
                <router-link to="/" class="btn btn-secondary">Back</router-link>
            </div>
        </div>
        <div class="card-body">
            <form action="">
                <div class="form-group">
                    <label for="title">URL</label>
                    <input type="text" name="url" id="url" class="form-control" v-model="bookmark.url" />
                </div>
                <button type="button" class="btn btn-secondary mt-2" v-on:click="saveBookmark()">Save</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "../config/axios.js";
import toastr from "toastr";

export default {
    name: 'Create',
    data() {
        return {
            bookmark: {} // Initial state
        };
    },
    methods: {
        async saveBookmark() {
            try {
                let res = await axios.post('/bookmarks', this.bookmark);
                this.$router.push({ name: 'Item', params: { id: res.data.data.id } })
            } catch (error) {
                let errors = error.response.data.errors;
                for (let key in errors) {
                    toastr.error(errors[key])
                }
            }
        },
    }
}
</script>
