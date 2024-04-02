const express = require('express')
const axios = require('axios')
const app = express()
const PORT = 3000

app.set('view engine', 'hbs')
app.set('views', __dirname + '/views')

app.get('/', (req, res) => {
  res.send('Hello, Express')
})

app.listen(PORT, () => {
  console.log(`The server is started on the port ${PORT}`)
})

app.get('/weather', (req, res) => {
  res.render('index')
})

app.get('/weather/current', async (req, res) => {
  const { lat, lon } = req.query
  const apiKey = 'fdd36c35ca1fc792abf77dce39c76a0c'
  const url = `http://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric&lang=uk`

  try {
    const response = await axios.get(url)
    const { data } = response
    res.json({
      city: data.name
    });
  } catch (error) {
    console.error(error)
    res.status(500).send(`Error getting weather data: ${error}`)
  }
})

app.get('/weather/:city', async (req, res) => {
  const city = req.params.city
  const apiKey = 'fdd36c35ca1fc792abf77dce39c76a0c'
  const url = `http://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=uk`

  try {
    const response = await axios.get(url)
    const { weather, main } = response.data
    res.render('weather', {
      city: city.charAt(0).toUpperCase() + city.slice(1),
      temperature: main.temp,
      description: weather[0].description,
      humidity: main.humidity,
      pressure: main.pressure
    })
  } catch (error) {
    res.send(`Error getting weather data: ${error}`)
  }
})
