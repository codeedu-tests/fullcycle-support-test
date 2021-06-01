const express = require('express')
const app = express()
const port = 3000

const config = {
    host: 'database',
    user: 'root',
    password: 'root',
    database: 'desafio_nginx_node'
}

const mysql = require('mysql')
const connection = mysql.createConnection(config)

const sql = `insert into people(name) values('Miguel')`
connection.query(sql)

app.set('view engine', 'ejs')

app.get('/', (req, res) => {
    connection.query("SELECT * from people", function (err, result) {
        if (err) throw err;
       
        res.render('people', {'listName': result})
   })
})

app.listen(port, () => {
     console.log('Rodando na porta ' + port)
})