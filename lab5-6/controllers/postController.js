const Post = require('../models/Post')

// Отримання всіх постів і відображення у вигляді списку
exports.getAllPosts = async (req, res) => {
  try {
    const posts = await Post.find({})
    res.render('postsList', { posts: posts })
  } catch (err) {
    res.status(500).send({ message: err.message })
  }
}

// Відображення сторінки для додавання нового посту
exports.addPostPage = (req, res) => {
  res.render('addPost')
}

// Створення нового посту
exports.createPost = async (req, res) => {
  const { title, author, text } = req.body
  try {
    await Post.create({ title, author, text })
    res.redirect('/posts')
  } catch (err) {
    res.status(500).send({ message: err.message })
  }
}

// Відображення сторінки для редагування посту
exports.editPostPage = async (req, res) => {
  try {
    const post = await Post.findById(req.params.id)
    res.render('editPost', { post })
  } catch (err) {
    res.status(404).send({ message: 'Post not found' })
  }
}

// Оновлення посту
exports.updatePost = async (req, res) => {
  const { title, author, text } = req.body
  try {
    const post = await Post.findById(req.params.id);

    if (!post) {
      return res.status(404).send({ message: "Post not found" });
    }

    post.title = title;
    post.author = author;
    post.text = text;
    post.updatedAt = new Date();

    await post.save();
    res.redirect('/posts')
  } catch (err) {
    res.status(500).send({ message: err.message })
  }
}

// Видалення посту
exports.deletePost = async (req, res) => {
  try {
    await Post.findOneAndDelete({ _id: req.params.id })
    res.redirect('/posts')
  } catch (err) {
    res.status(500).send({ message: err.message })
  }
}

// Отримання всіх постів у json форматі
exports.getPostsJson = async (req, res) => {
  try {
    const posts = await Post.find({}).lean();
    res.json(posts);
  } catch (err) {
    res.status(500).send({ message: err.message });
  }
};
