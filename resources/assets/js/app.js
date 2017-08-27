
require('./bootstrap');

window.Vue = require('vue');

import Buefy from 'buefy';
import Vue2Filters from 'vue2-filters'

import TaskListItem from './components/TaskListItem.vue';
import StudioListItem from './components/StudioListItem.vue';
import TaskStatusesItem from './components/TaskStatusesItem.vue';

import ManageTasksItem from './components/ManageTasksItem.vue';
import ManageStatusesItem from './components/ManageStatusesItem.vue';
import ManageTasksChildrenItem from './components/ManageTasksChildrenItem.vue';


Vue.use(Vue2Filters)
Vue.use(Buefy, {
    defaultIconPack: 'fa'
});

Vue.component('task-list-item', TaskListItem);
Vue.component('studio-list-item', StudioListItem);
Vue.component('task-statuses-item', TaskStatusesItem);

Vue.component('manage-statuses-item', ManageStatusesItem);
Vue.component('manage-tasks-item', ManageTasksItem);
Vue.component('manage-tasks-children-item', ManageTasksChildrenItem);

new Vue({ el: '#app', data: { navigation: {}, activeTab: null, } });
