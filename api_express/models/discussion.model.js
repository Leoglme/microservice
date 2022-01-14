const mongoose = require('mongoose');


const DiscussionSchema = new mongoose.Schema({
    name: {
        type: String,
        required: true,
        maxlength: 120
    },
    users: {
        type: Array,
        required: false,
        default: null
    }
}, {timestamps: true, collection: 'discussion'});


const Discussion = module.exports = mongoose.model('Discussion', DiscussionSchema);
