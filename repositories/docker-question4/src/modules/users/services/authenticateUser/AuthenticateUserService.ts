import { compare } from "bcrypt";
import { sign } from 'jsonwebtoken'
import { inject, injectable } from "tsyringe";
import AppError from "../../../../shared/errors/AppError";
import IUsersRepository from "../../repositories/IUsersRepository";

interface IRequest {
    email: string
    password: string
}

interface IResponse {
    user: {
        name: string
        email: string
    }
    token: string
}

@injectable()
export default class AuthenticateUserService {

    constructor(
        @inject('UsersRepository')
        private usersRepository: IUsersRepository
    ) { }

    async execute({ email, password }: IRequest): Promise<IResponse> {
        const user = await this.usersRepository.findByEmail(email)

        if (!user) {
            throw new AppError('E-mail or password incorrect!')
        }

        const passMatch = await compare(password, user.password)

        if (!passMatch) {
            throw new AppError('E-mail or password incorrect!')
        }

        //dados que irão no response, secretId, subject e expiracao
        const token = sign({}, "bbd4630b80057226bd6647b5a1d87697",
            {
                subject: user.id,
                expiresIn: '1d'
            })

        const tokenReturn: IResponse = {
            token,
            user: {
                name: user.name,
                email: user.email
            }
        }

        return tokenReturn
    }

}