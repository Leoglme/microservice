const Discussion = require('../models/discussion.model');
const {body, validationResult} = require('express-validator');
const mongoose = require("mongoose");
const {getById} = require("./discussion.controller");

exports.create = async (req, res, next) => {
    const name = req.body.name;
    body('name', 'Discussion name is required').notEmpty();
    body('name', 'Discussion name must contain less than 120 characters').isLength({max: 120});

    const errors = validationResult(req);
    if (!errors.isEmpty()) {
        console.log("form blog validate errors", errors);
        return res.status(500).json({errors: errors.array()});
    } else {
        const newDiscussion = new Discussion({name});
        await newDiscussion.save()
            .then(result => {
                console.log(result);
                res.status(200).json({
                    message: 'Discussion created',
                    result: result,
                    success: true,
                });
            })
            .catch(err => {
                console.log(err);
                res.status(500).json({
                    error: err,
                    success: false,
                });
            })
    }
};

exports.list = async (req, res, next) => {
    const discussions = await Discussion.find({})
    await console.log(discussions);
    res.status(200).json({
        discussions,
        success: true,
    });
};

exports.getById = async (req, res, next) => {
    const id = req.params.id;
    if (!mongoose.Types.ObjectId.isValid(id)) {
        return res.status(500).json({
            error: "The Id has an invalid format",
            success: false,
        })
    }
    return await Discussion.findById(id)
        .then((r) => res.status(200).json({
            discussion: r,
            success: true,
        }))
        .catch((err) => res.status(500).json({
            error: err,
            success: false,
        }));
};

exports.isset = async (req, res, next) => {
    const id = req.params.id;
    if (!mongoose.Types.ObjectId.isValid(id)) {
        res.status(404);
        return res.send(false);
    }
    return await Discussion.findById(id)
        .then((r) => {
            res.status(200);
            return res.send(true);
        })
        .catch((err) => {
            res.status(401);
            return res.send(false);
        });
};

exports.addUsers = async (req, res, next) => {
    const id = req.params.id;
    const users = req.body.users;
    body('users', 'Users is required').notEmpty();

    const errors = validationResult(req);
    const discussion = await Discussion.findById(id);
    const discussionExist = discussion.length !== 0;

    if (!discussionExist) {
        console.log("discussion not exist");
        res.status(500).json({
            error: "Sorry, discussion do not exit",
            success: false,
        });
    }
    if (!errors.isEmpty()) {
        console.log("form blog validate errors", errors);
        return res.status(500).json({errors: errors.array()});
    } else {
        let cond = {_id: id};
        const isEmptyUsers = users.length === 0;
        const formatUsers = users.map(user => user.toString())


        await Discussion.findById(id)
            .then(async (r) => {
                const sortUser = users.filter(e => !r.users.includes(e.toString()))
                if (isEmptyUsers || sortUser.length === 0) {
                    console.log({isEmptyUsers, sortUser})
                    res.status(500).json({
                        error: "Sorry, the users cannot be empty",
                        success: false,
                    })
                } else {
                    let update = {$push: {users: {$each: formatUsers}}};

                    let opts = {
                        safe: true,
                        upsert: true,
                        new: true
                    };
                    await Discussion.findByIdAndUpdate(cond, update, opts)
                        .then((r) => res.status(200).json({
                            discussion: r,
                            success: true,
                        }))
                        .catch((err) => res.status(500).json({
                            error: err,
                            success: false,
                        }));
                }
            })
            .catch((err) => {
                return {
                    error: err,
                    success: false,
                }
            });
    }
};

exports.update = async (req, res, next) => {
    const id = req.params.id;
    const name = req.body.name;
    const users = req.body.users;

    body('name', 'Discussion name is required').notEmpty();
    body('users', 'Users is required').notEmpty();
    body('name', 'Discussion name must contain less than 120 characters').isLength({max: 120});

    const errors = validationResult(req);
    const discussion = await Discussion.findById(id);
    const discussionExist = discussion.length !== 0;

    if (!discussionExist) {
        console.log("discussion not exist");
        res.status(500).json({
            error: "Sorry, discussion do not exit",
            success: false,
        });
    }
    if (!errors.isEmpty()) {
        console.log("form blog validate errors", errors);
        return res.status(500).json({errors: errors.array()});
    } else {
        let cond = {_id: req.params.id};
        let update = {name, users: users.map(user => user.toString())};
        let opts = {
            upsert: true,
            new: true
        };
        Discussion.findByIdAndUpdate(cond, update, opts)
            .then((r) => res.status(200).json({
                discussion: r,
                success: true,
            }))
            .catch((err) => res.status(500).json({
                error: err,
                success: false,
            }));
    }
};

exports.delete = async (req, res, next) => {
    let cond = {_id: req.params.id};
    await Discussion.findOneAndDelete(cond)
        .then(() => res.send(200, "Discussion deleted."))
        .catch(() => res.send(500, "Failed to delete the discussion."));
};
