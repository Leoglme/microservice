const express = require('express');
const router = express.Router();
const DiscussionController = require('../controllers/discussion.controller');
const {authenticateToken} = require("../middleware/JwtMiddleware");

/**
 * @swagger
 * tags:
 *   name: Discussion
 *   description: The Discussion managing API
 */


/**
 * @swagger
 * /discussion/list:
 *   get:
 *     summary: Returns the list of all the discussions
 *     tags: [Discussion]
 *     responses:
 *       200:
 *         description: The list of the discussions
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Discussion'
 */
router.get('/list', authenticateToken, DiscussionController.list);


/**
 * @swagger
 * /discussion/isset/{id}:
 *   get:
 *     summary: Check if a discussion exists
 *     tags: [Discussion]
 *     parameters:
 *      - in: path
 *        name: id
 *        schema:
 *        type: string
 *        required: true
 *        description: The discussion id
 *     responses:
 *       200:
 *         description: Success
 *         content:
 *           application/json:
 *             schema:
 *               type: Boolean
 */
router.get('/isset/:id', authenticateToken, DiscussionController.isset);

/**
 * @swagger
 * /discussion/{id}:
 *   get:
 *     summary: Get discussion with your id
 *     tags: [Discussion]
 *     parameters:
 *      - in: path
 *        name: id
 *        schema:
 *        type: string
 *        required: true
 *        description: The discussion id
 *     responses:
 *       200:
 *         description: The discussion result
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               $ref: '#/components/schemas/Discussion'
 */
router.get('/:id', authenticateToken, DiscussionController.getById);

/**
 * @swagger
 * /discussion:
 *   post:
 *     summary: Create a new discussion
 *     tags: [Discussion]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/DiscussionLightViewModel'
 *     responses:
 *       200:
 *         description: The discussion was successfully created
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Discussion'
 *       500:
 *         description: Some server error
 */

router.post('/', authenticateToken, DiscussionController.create);

/**
 * @swagger
 * /discussion/{id}:
 *  put:
 *    summary: Update the discussion by the id
 *    tags: [Discussion]
 *    parameters:
 *      - in: path
 *        name: id
 *        schema:
 *          type: string
 *        required: true
 *        description: The discussion id
 *    requestBody:
 *      required: true
 *      content:
 *        application/json:
 *          schema:
 *            $ref: '#/components/schemas/DiscussionViewModel'
 *    responses:
 *      200:
 *        description: The discussion was updated
 *        content:
 *          application/json:
 *            schema:
 *              $ref: '#/components/schemas/Discussion'
 *      404:
 *        description: The discussion was not found
 *      500:
 *        description: Some error happened
 */

router.put('/:id', authenticateToken, DiscussionController.update);


/**
 * @swagger
 * /discussion/users/{id}:
 *  put:
 *    summary: Add users into a discussion
 *    tags: [Discussion]
 *    parameters:
 *      - in: path
 *        name: id
 *        schema:
 *          type: string
 *        required: true
 *        description: The discussion id
 *    requestBody:
 *      required: true
 *      content:
 *        application/json:
 *          schema:
 *            $ref: '#/components/schemas/UsersViewModel'
 *    responses:
 *      200:
 *        description: The discussion was updated
 *        content:
 *          application/json:
 *            schema:
 *              $ref: '#/components/schemas/Discussion'
 *      404:
 *        description: The discussion was not found
 *      500:
 *        description: Some error happened
 */

router.put('/users/:id', authenticateToken, DiscussionController.addUsers);


/**
 * @swagger
 * /discussion/{id}:
 *   delete:
 *     summary: Remove the discussion by id
 *     tags: [Discussion]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: string
 *         required: true
 *         description: The discussion id
 *
 *     responses:
 *       200:
 *         description: The discussion was deleted
 *       404:
 *         description: The discussion was not found
 */

router.delete('/:id', authenticateToken, DiscussionController.delete);
module.exports = router;


/*Swagger models*/
/**
 * @swagger
 * components:
 *   schemas:
 *     Discussion:
 *       type: object
 *       required:
 *         - name
 *       properties:
 *         id:
 *           type: string
 *           description: The auto-generated id of the discussion
 *         name:
 *           type: string
 *           description: The discussion title
 *         users:
 *           type: array
 *           description: Discussion users
 *       example:
 *         id: 507f191e810c19729de860ea
 *         name: The New Discussion
 *         users: [507f191e810c19729de860ea, 507f191e810c19729de860ea]
 */

/**
 * @swagger
 * components:
 *   schemas:
 *     DiscussionLightViewModel:
 *       type: object
 *       required:
 *         - name
 *       properties:
 *         name:
 *           type: string
 *           description: The discussion title
 *       example:
 *         name: The New Discussion
 */

/**
 * @swagger
 * components:
 *   schemas:
 *     DiscussionViewModel:
 *       type: object
 *       required:
 *         - name
 *       properties:
 *         name:
 *           type: string
 *           description: The discussion title
 *         users:
 *           type: array
 *           description: Discussion users
 *       example:
 *         name: The New Discussion
 *         users: [507f191e810c19729de860ea, 507f191e810c19729de860ea]
 */

/**
 * @swagger
 * components:
 *   schemas:
 *     UsersViewModel:
 *       type: object
 *       required:
 *         - users
 *       properties:
 *         users:
 *           type: array
 *           description: Discussion users
 *       example:
 *         users: [507f191e810c19729de860ea, 507f191e810c19729de860ea]
 */
