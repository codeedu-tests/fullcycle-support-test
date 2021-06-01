import { inject, injectable } from "tsyringe";
import { hash } from "bcrypt";
import AppError from "../../../../shared/errors/AppError";
import IRegisterUserDTO from "../../dtos/IRegisterUserDTO";
import IUsersRepository from "../../repositories/IUsersRepository";
import User from "@modules/users/infra/typeorm/entities/User";

@injectable()
export default class CreateUserService {

    constructor(
        @inject('UsersRepository')
        private usersRepository: IUsersRepository
    ) { }

    async execute(data: IRegisterUserDTO): Promise<User> {
        const userExists = await this.usersRepository.findByEmail(data.email)

        if (userExists) {
            throw new AppError('User already exists!')
        }

        const passwordHashed = await hash(data.password, 8)
        data.password = passwordHashed
        const user = await this.usersRepository.create({ ...data })
        return user
    }

}