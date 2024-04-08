const express = require('express')
const mongoose = require('mongoose')
const { engine } = require('express-handlebars')
const postRoutes = require('./routes/postRoutes')
const moment = require('moment')
const app = express()
const port = 3000

app.engine('hbs', engine({
  extname: '.hbs',
  defaultLayout: 'main',
  runtimeOptions: {
    allowProtoPropertiesByDefault: true,
    allowProtoMethodsByDefault: true
  },
  helpers: {
    formatDate: function (date, format) {
      return moment(date).format(format)
    }
  }
})
)
app.set('view engine', 'hbs')
app.set('views', './views')

app.use(express.json())
app.use(express.urlencoded({ extended: true }))
app.use('/posts', postRoutes)

mongoose
  .connect(
    'mongodb+srv://bashchakyaryna:wUDknwFCy29zUlCK@cluster0.srklcrx.mongodb.net/?retryWrites=true&w=majority&appName=cluster0'
  )
  .then(() => console.log('Successfully connected to MongoDB'))
  .catch(err => console.error('Connection error', err))

app.listen(port, () => {
  console.log(`Server is running on port ${port}`)
})
