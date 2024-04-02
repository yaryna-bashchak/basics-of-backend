const express = require('express');
const app = express();
const PORT = 3000;

app.set('view engine', 'hbs');
app.set('views', __dirname + '/views');

app.get('/', (req, res) => {
    res.send('Hello, Express');
});

app.listen(PORT, () => {
    console.log(`Сервер запущено на порту ${PORT}`);
});

app.get('/weather', (req, res) => {
    res.render('index');
});

app.get('/weather/:city', (req, res) => {
    const city = req.params.city;

    res.send(`Погода в місті ${city}: сонячно, +23°C`);
});
