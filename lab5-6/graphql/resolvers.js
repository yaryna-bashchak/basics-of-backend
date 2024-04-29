const Post = require('../models/Post');

const resolvers = {
  getPost: ({ id }) => {
    return Post.findById(id);
  },
  listPosts: () => {
    return Post.find();
  },
  createPost: ({ title, author, text }) => {
    const newPost = new Post({ title, author, text });
    return newPost.save();
  },
  updatePost: ({ id, title, author, text }) => {
    return Post.findByIdAndUpdate(id, { title, author, text }, { new: true });
  },
  deletePost: ({ id }) => {
    return Post.findByIdAndDelete(id);
  }
};

module.exports = resolvers;
