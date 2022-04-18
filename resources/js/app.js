require('./bootstrap');
import Dropzone from "dropzone";
window.moment = require('moment');

Dropzone.autoDiscover = false;


window.TABLE_MANAGEMENT_PROPS = {
    dom: 'plfrtipl',
    pageLength: 5,
    lengthMenu: [5, 10, 20, 50, 100],
    responsive: true,
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    bStateSave: true,
    stateSaveParams: function(settings, data) {
    data.search.search = "",
    data.order = [[0, 'desc']]
    }
}
