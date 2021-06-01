import UsersRepository from "@modules/users/infra/typeorm/repositories/UsersRepository";
import { NextFunction, request, Request, Response } from "express";

import { verify } from 'jsonwebtoken'
import AppError from "../../../errors/AppError";

interface IPayload {
    sub: string
}

export default async function ensureAuthenticated(req: Request, resp: Response, next: NextFunction) {
    const authHeader = req.headers.authorization

    if (!authHeader) {
        throw new AppError('Token is missing!', 401)
    }

    const [, token] = authHeader.split(' ')

    try {
        const { sub: user_id } = verify(token, 'bbd4630b80057226bd6647b5a1d87697') as IPayload

        const usersRepository = new UsersRepository()
        const userExists = await usersRepository.findById(user_id)

        if (!userExists) {
            throw new AppError('User doen\'t exist!', 401)
        }

        request.user_id = user_id

        next()
    } catch (err) {
        throw new AppError('Invalid token!', 401)
    }
}