const express = require('express');
const router = express.Router();
const postController = require('../controllers/postController');

router.get('/', postController.getAllPosts);
router.get('/add', postController.addPostPage);
router.get('/edit/:id', postController.editPostPage);
router.post('/add', postController.createPost);
router.post('/edit/:id', postController.updatePost);
router.get('/delete/:id', postController.deletePost);

module.exports = router;
