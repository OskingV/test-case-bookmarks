import List from "./components/bookmark/List.vue";
import Create from "./components/bookmark/Create.vue";
import Item from "./components/bookmark/Item.vue";

export const routes = [
    {
        path: "/",
        name: "List",
        component: List,
    },
    {
        path: "/create",
        name: "Create",
        component: Create,
    },
    {
        path: "/item/:id",
        name: "Item",
        component: Item,
    },
];
