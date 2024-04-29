const { buildSchema } = require('graphql');

const schema = buildSchema(`
  type Post {
    id: ID!
    title: String
    author: String
    text: String
    createdAt: String
    updatedAt: String
  }

  type Query {
    getPost(id: ID!): Post
    listPosts: [Post]
  }

  type Mutation {
    createPost(title: String!, author: String!, text: String!): Post
    updatePost(id: ID!, title: String, author: String, text: String): Post
    deletePost(id: ID!): Post
  }
`);

module.exports = schema;
