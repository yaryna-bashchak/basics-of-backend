const express = require('express');
const mongoose = require('mongoose');
const postRoutes = require('./routes/postRoutes');
const app = express();
const port = 3000;

app.use(express.json());
app.use('/posts', postRoutes);

mongoose.connect('mongodb+srv://bashchakyaryna:wUDknwFCy29zUlCK@cluster0.srklcrx.mongodb.net/?retryWrites=true&w=majority&appName=cluster0')
  .then(() => console.log('Successfully connected to MongoDB'))
  .catch(err => console.error('Connection error', err));

app.listen(port, () => {
console.log(`Server is running on port ${port}`);
});