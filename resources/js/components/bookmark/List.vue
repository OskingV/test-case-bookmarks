<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Data</h1>
                <a href="/api/bookmarks/excel" download>
                    <button type="button" class="btn btn-warning">Download excel</button>
                </a>
                <router-link to="/create" class="btn btn-secondary">Create</router-link>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Created at <sort field="created_at"></sort></th>
                    <th>Favicon</th>
                    <th>URL <sort field="url"></sort></th>
                    <th>Title <sort field="title"></sort></th>
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
                            to="/create" class="btn btn-info">
                            <font-awesome-icon :icon="['fas', 'eye']" />
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination :data="laravelData" @pagination-change-page="getBookmarksByPage"></pagination>
        </div>
    </div>
</template>

<script>
import axios from "../config/axios.js";

export default {
    name: "List",
    data() {
        return {
            bookmarks: [], // Initial state
            laravelData: {},
            page: 1,
            sortField: null,
            sortType: null,
        };
    },
    mounted() {
        this.getBookmarksByPage();
    },
    methods: {
        async getBookmarksByPage() {
            const payload = {
                page: this.page
            };
            if (!(this.sortField === null && this.sortType === null)) {
                payload.sort_field = this.sortField;
                payload.sort_type = this.sortType;
            }
            const queryString = this.getQueryStringList(payload);
            let res = await axios.get(`/bookmarks?${queryString}`);
            this.bookmarks = res.data.data;
            this.laravelData = res.data;
        },
        async getSortList (field, type) {
            const payload = {
                sort_field: field,
                sort_type: type,
                page: this.page
            };
            const queryString = this.getQueryStringList(payload);
            let res = await axios.get(`/bookmarks?${queryString}`);
            this.bookmarks = res.data.data;
            this.laravelData = res.data;
            this.sortField = field;
            this.sortType = type;
        },
        getQueryStringList (payload) {
            return Object.keys(payload).map(key => key + '=' + payload[key]).join('&');
        }
    },
};
</script>
