import NotFound from "./components/NotFound";
import Chart from "../modules/Chart/components/Chart";

export const routes = [
    {
        path: '/',
        name: 'Chart',
        component: Chart,
    },
    {
        path: '*',
        component: NotFound,
        name: 'not_found'
    }
];

