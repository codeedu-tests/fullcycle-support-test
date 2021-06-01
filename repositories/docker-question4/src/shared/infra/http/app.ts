import 'reflect-metadata'
import express, { NextFunction, Request, response, Response } from 'express'
import 'express-async-errors'

import '../typeorm/index'

import '../../container'

import routes from './routes'
import AppError from '../../errors/AppError'

const app = express()
app.use(express.json())
app.use(routes)

app.use((err: Error, req: Request, res: Response, next: NextFunction) => {
    if (err instanceof AppError) {
        return res.status(err.statusCode).json({
            message: err.message
        })
    }

    console.log('-> ' + err)

    return response.status(500).json({
        status: 'error',
        message: `Internal server error: ${err}`
    })
})

export default app